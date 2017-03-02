<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Posts;
use AppBundle\Entity\User;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class UserController
 * @package AppBundle\Controller
 */
class UserController extends Controller
{
    /**
     * @Route("/users/", name="allUsers")
     * @Method({"GET"});
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function usersAction()
    {
        $em = $this->getDoctrine()->getManager();
        $usersRepository = $em->getRepository('AppBundle:User');
        $users = $usersRepository->findAll();

        $result = array();
        foreach ($users as $user) {
            $result[] = array(
                'id' => $user->getId(),
                'username' => $user->getUsername(),
                'first_name' => $user->getFirstName(),
                'last_name' => $user->getLastName()
            );
        }

        return $this->json($result);
    }

    /**
     * @Route("/users/{id}", name="oneUser")
     * @Method({"GET"});
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function userAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $userRepository = $em->getRepository('AppBundle:User');
        $user = $userRepository->findOneBy(array('id' => $request->get('id')));

        $result = array(
            'id' => $user->getId(),
            'username' => $user->getUsername(),
            'first_name' => $user->getFirstName(),
            'last_name' => $user->getLastName()
        );

        return $this->json($result);
    }
}
