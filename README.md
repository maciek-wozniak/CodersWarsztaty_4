# CodersWarsztaty_4

Notice board: add notices, browse them and comment.

Website was created using:
- HTML
- CSS
- Bootstrap front-end framework
- OOP PHP
- js
- Symfony2
- FOSUserBundle 
- Doctrine 2 ORM, DQL
- Twig templates
- sweetalert

Implemented features:
- registration
- user login and logout
- editing user profil
- admin can add and manage notice's categories
- logged user can add notice with optional one picture
- notice will be displayed on board till expiration date
- everyone can see all, not expired notices, and display them by category
- everyone can comment notices
- user can edit his notices, and delete his notices comments
- admin can edit all notices and delete all coments
- user can see his expired notices
- admin can see all expired notices

Installation guide:
- download repository
- unpack zip file
- open command line and type: 'cd board' to browse board directory
- next at command line type: 'composer install' - provide database parameters when asked
- next at command line type: php app/console doctrine:database:create
- next at command line type: php app/console doctrine:schema:update --force
- next at command line type: php app/console server:start
- browse: http://localhost:8000 
- promoting testuser - type ad command line: php bin/console fos:user:promote testuser ROLE_ADMIN
