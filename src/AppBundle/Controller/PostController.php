<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Posts;
use AppBundle\Entity\User;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class PostController
 * @package AppBundle\Controller
 */
class PostController extends Controller
{
    /**
     * @Route("/", name="allPosts")
     * @Method({"GET"});
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function postsAction()
    {
        $em = $this->getDoctrine()->getManager();
        $postsRepository = $em->getRepository('AppBundle:Posts');
        $posts = $postsRepository->findAll();

        $result = array();
        foreach ($posts as $post) {
            $result[] = array(
                'id' => $post->getId(),
                'post' => $post->getPost(),
                'user' => $post->getUserId(),
                'created_at' => $postsRepository->timing($post->getCreatedAt()) . ' ago'
            );
        }

        return $this->json($result);
    }

    /**
     * @Route("/posts/{id}", name="onePost")
     * @Method({"GET"});
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function postAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $postsRepository = $em->getRepository('AppBundle:Posts');
        $post = $postsRepository->findOneBy(array('id' => $request->get('id')));

        $result = array(
            'id' => $post->getId(),
            'post' => $post->getPost(),
            'user' => $post->getUserId(),
            'created_at' => $postsRepository->timing($post->getCreatedAt()) . ' ago'
        );

        return $this->json($result);
    }

    /**
     * @Route("/posts/create", name="createPost")
     * @Method({"POST"});
     * @param Request $request
     */
    public function createAction(Request $request)
    {
        /** @var User $user */
        $user = $this->getUser();
        if ($request->request->count() > 0 && !empty($user)) {
            $postData = $request->request->get('post');
            if (!empty($postData)) {
                $post = new Posts();
                $post->setCreatedAt(new \DateTime());
                $post->setUserId($user->getId());
                $post->setPost($postData);

                $em = $this->getDoctrine()->getManager();
                $em->persist($post);
                $em->flush();
            }
        }
    }

    /**
     * @Route("/posts/delete/{id}", name="deletePost")
     * @Method({"DELETE"});
     * @param Request $request
     */
    public function deleteAction(Request $request)
    {
        /** @var User $user */
        $user = $this->getUser();
        if ($request->get('id') > 0 && !empty($user)) {
            $em = $this->getDoctrine()->getManager();
            $posts = $em->getRepository('AppBundle:Posts');
            $post = $posts->findOneBy(array('id' => $request->get('id')));
            $post->setDeleted(true);
            $post->setDeletedAt(new \DateTime());

            $em->persist($post);
            $em->flush();
        }
    }
}
