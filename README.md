CodeIgniter-Plus
================

CodeIgniter 2.20, HMVC, Base-Model, BootStrap 3.2, IonAuth +, Template

---

It's a fully functional application that have the following features:

1. CodeIgniter 2.20 with HMVC
1. It is styled with BootStrap 3.20
1. It having IonAuth working as a HMVC
1. It has a role base as well as the group, so you can test if the user is `in_group()` or you can use `has_role()`
1. It also have a database driven navigation as well as sorting and managing the navigation
1. It also have a site preferences
1. Language, css, js, images, etc... can be module base if needed
1. Uses the Base-Model
1. Finally it uses the Template
1. The roles are database driven and you can use a single role or 	a crud roles, for example you can create:

* **"can_do_this"** as a role or
* **"testing"** role as a group of roles, and it will automatically create 4 roles: **create_testing**,  **update_testing**, **read_testing** and **delete_testing**.

===
**Installation**
---

1. Copy all the folder to your server
1. Create a database in your local (server)
1. Open the database.php file and change it with the information
1. point in your browser to your domain by going to `http://yourdomain/migrate/latest`
1. Once it's done, then point to your domain by going to `http://yourdomain/`
1. Make sure to delete the migrate.php in the application/controllers/migrate.php to avoid some one play with your database especially if you are installing it on a live site

* **Username**: administrator
* **Password**: password

---

_if you have any suggestions to be added to this app, you are welcome to ask._

---
Credits:
- [EllisLab - CodeIgniter](https://github.com/EllisLab/CodeIgniter)
- [Modular Extensions - HMVC](https://bitbucket.org/wiredesignz/codeigniter-modular-extensions-hmvc)
- [Base Model](https://github.com/jamierumbelow/codeigniter-base-model/blob/master/core/MY_Model.php)
- [Ion Auth](https://github.com/benedmunds/CodeIgniter-Ion-Auth)
- [Template](https://github.com/philsturgeon/codeigniter-template)

---
**A demo can be watched at** [YouTube (Coming Soon)](#)
