# Introduction

User module provide API interfaces to create user accounts, retrive all user data, find spacific user, update own profile, delete user, update user role and reset password.

## Base URL

All endpoints are relative to the base URL of your Laravel application.

---

# Authentication

To access these endpoints, authentication is required. Use appropriate tokens or authentication mechanisms to access the endpoints.

> to authnticate the request every request should be bind with  `bearer token`

> Admin authentication is required fro all endpoints except update.

> Update endpoint can be acceessd with any auth token but update action is limited to the user who represented by the auth token.

---

# Endpoints

## Register User

| Method | URI |
| : |   :-   |
| POST | /api/user/register |

Registers a new user with the provided information.

### Request Body

```json
{
    "first_name": "string",
    "last_name": "string",
    "email": "string",
    "username": "string",
    "password": "string",
    "password_confirmation": "string",
    "role": "string" // Optional: 'admin', 'supervisor', 'user'
}
```

### Response
```json
{
    "status": 200,
    "message": "User Create Success",
    "user": { "user_details": "here" }
}
```

---

## View Users

| Method | URI |
| : |   :-   |
| GET | /api/user/view |

Retrieves a list of all users.

### Response
Success with data
```json
{
    "status": 200,
    "users": [ { "user_details": "here" }, { "user_details": "here" } ]
}
```

Success With No data
```json
{
    "status": 204,
    "message": "No user for provided user id"
}
```

---

## Find User

| Method | URI |
| : |   :-   |
| GET | /api/user/view/{id} |

Retrieves details of a specific user by ID.

### Response

```json
{
    "status": 200,
    "user": { "user_details": "here" }
}
```

---

## Update User

| Method | URI |
| : |   :-   |
| PUT | /api/user/update/{id} |

Updates the profile of the authenticated user.

### Request Body
```json
{
    "first_name": "string",
    "last_name": "string",
    "email": "string",
    "password": "string",
    "password_confirmation": "string"
}
```

### Response
Successful Update
```json
{
    "status": 200,
    "message": "Data Updated Success",
    "user": { "user_details": "here" }
}
```

Request from anauthorized user
User recognized by the token of the request
```json
{
    "status": 401,
    "message": "Unauthorized user id"
}
```

---

## Delete User

| Method | URI |
| : |   :-   |
| DELETE | /api/user/delete/{id}|

Deletes a user by ID.

> {danger.fa-lightbulb} Deletes performed by this controller are soft deletes.

### Response
Successful soft delete of data record
```json
{
    "status": 200,
    "message": "User delete success",
    "user": { "user_details": "here" }
}
```

Couldn't find user reprented by the provided id.
Possibly deleted user/ invalid user id
```json
{
    "status": 204,
    "message": "No user for provided user id"
}
```
---

## Reset Password

| Method | URI |
| : |   :-   |
| PUT | /api/user/reset_password/{id} |

Resets the password of a user by ID.

### Response
Successful Reset of password password default password is `password`
```json
{
    "status": 200,
    "message": "Password Reset Success"
}
```

Couldn't find user reprented by the provided id.
> Possibly deleted user/ invalid user id
```json
{
    "status": 204,
    "message": "No user for provided user id"
}
```

---

## Update User Role

| Method | URI |
| : |   :-   |
| PUT | /api/user/update_role/{id} |

Updates the role of a user by ID.

### Request Body
```json
{
    "role": "string" // 'admin', 'supervisor', 'user'
}
```

### Response
Successful change of user role
```json
{
    "status": 200,
    "message": "Change Role Success"
}
```

Couldn't find user reprented by the provided id.
> Possibly deleted user/ invalid user id
```json
{
    "status": 204,
    "message": "No user for provided user id"
}
```

---

# Error Handling
Proper error responses will be returned in case of validation errors, authentication failures, or other issues. Ensure to handle these responses accordingly.