Symfony REST API Demo
========================

Vagrant installation
-----

Make sure you have Vagrant and VirtualBox installed.

```bash
$ composer install
$ vagrant up
```

Run behat tests

```bash
$ vagrant ssh
$ cd /vagrant
$ ./vendor/bin/behat
```

API Endpoints
-----

```bash
GET /api/v1/users
GET /api/v1/users/1
POST /api/v1/users
POST /api/v1/users/1

GET /api/v1/groups
GET /api/v1/groups/1
POST /api/v1/groups
POST /api/v1/groups/1
```

Example requests
----

#### Create User

```
POST /api/v1/users
```

```json
{
	"email": "email@yandex.com",
	"firstName": "SomeName",
	"LastName": "SomeLastName",
	"active": true,
	"group_id": 1
}
```

#### Create Group

```
POST /api/v1/groups
```

```json
{
  "name":"ASD Group",
  "user_ids": [1,2,3]
}
```