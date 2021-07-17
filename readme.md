**setup**

`composer install`

`php artisan key:generate`

**docments l5-repository**

[https://github.com/andersao/l5-repository]

****Login****

[https://jwt-auth.readthedocs.io/en/develop/quick-start/#add-some-basic-authentication-routes]

`php artisan jwt:secret`

****fix lỗi cors****

[https://chrome.google.com/webstore/detail/moesif-origin-cors-change/digfbfaphojjndkpccljibejjbppifbc/related?hl=en-US]

[https://github.com/fruitcake/laravel-cors]

`composer require fruitcake/laravel-cors`

`php artisan optimize:clear`

`php artisan config:cache`

`php artisan cache:clear`

bug => create foder framework in storage 

****migrate****

````
add columns to tables
php artisan make:migration add_paid_to_users_table --table=users
php artisan migrate
````

****API****

-   DANG NHAP
    
    + url : [POST][https://sangpt97.herokuapp.com/api/auth/login]
    
    **body data**

    `email` : dia chi email

    `password` : mat khau

-    DANG KY

    + url : [POST][https://sangpt97.herokuapp.com/api/auth/register]

    **body data**
    
    `name` : Ten nguoi dung

    `email` : dia chi email

    `password` : mat khau

-   LAY THONG TIN DANG NHAP    

    + [GET][https://sangpt97.herokuapp.com/api/auth/me]

    ***Authorization***

    Bearer Token  = token login eg: `eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJodHRwOi8vc2FuZ3B0OTcuaGVyb2t1YXBwLmNvbS9hcGkvYXV0aC9sb2dpbiIsImlhdCI6MTYyMzY0MDEwMywiZXhwIjoxNjIzNzI2NTAzLCJuYmYiOjE2MjM2NDAxMDMsImp0aSI6IjhmVmI5THFjaXdVaUZ4cHciLCJzdWIiOjEsInBydiI6ImY2YjcxNTQ5ZGI4YzJjNDJiNzU4MjdhYTQ0ZjAyYjdlZTUyOWQyNGQifQ.MuWjXW8vJlAe74mpihIV9XB9Va4241hpp_Z58xhItWQ` 
    
-   LAY DANH SACH BAI POSTS
    
    + [GET][https://sangpt97.herokuapp.com/api/home]

    ***Authorization***
    Bearer Token  = token login

-   POST

    + `post_description`, `photos[]`
    
    + [POST][http://127.0.0.1:8000/api/post/create]

    + ###### post by `id`
    
    + [GET][http://127.0.0.1:8000/api/post/detail/{id}]
    
    + [POST][http://127.0.0.1:8000/api/post/update/{id}]
    
    + [DELETE][http://127.0.0.1:8000/api/post/delete/{id}]
    
    + ###### post by `user_id`
    
    + [GET][http://127.0.0.1:8000/api/post/by-user/{id}]    
    
    + ###### like post `post_id`
    
    + [POST][http://127.0.0.1:8000/api/like]
    
+ get profile user and list friends `id_user`
    
    + [GET][http://127.0.0.1:8000/api/user/detail-info/{id}]
    


    
    
    
