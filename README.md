#Test work - Symfony edition

### Task:

> We have an application, where each of our employees can write some posts, and other users can see them. Database has 
~1000 records and is populated by 10 - 20 records per day. 
> Consider, that we have field created_at in database as string in format dd.mm.yyyy hh:mm:ss. 
> All dates should be in human language (like - “one hour ago”, “two days ago”).

__Create simple WEB API, which has such methods:__

* For posts:
    * Create - create a post in database, associated to user
    * Delete - mark post as deleted in database by post ID
    * List - show all valid posts divided by pages. 25 posts per page. Ordered by created_at field.
    * Show - show valid post by post ID
* For users:
    * List - show all active users
    * Show - show user and his posts, by user’s ID

__Database structure:__

* users
    * id
    * username
    * token
    * first_name
    * last_name
* posts
    * id
    * user_id
    * post
    * created_at
    * deleted_at

### Requirements

1. PHP >= 5.6
2. MySQL
3. Composer

### Installation

```bash
$ composer install
```
