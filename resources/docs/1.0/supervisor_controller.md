# Introduction

The Supervisor Controller manages authorization queues and breakdown statuses within the application. This documentation details the available endpoints and their functionalities.

## Base URL

All endpoints are relative to the base URL of your Laravel application.

---

# Authentication

To access these endpoints, authentication is required. Use appropriate tokens or authentication mechanisms to access the endpoints.

> to authnticate the request every request should be bind with  `bearer token`

> Supervisor authentication is required for RETRIVE, FIND and AUTH endpoints.

---

# Endpoints

## Retrieve All
Retrieves all data with pagination.

| Method | URI | Headers |
| : |   :   | : |
| GET | /api/supervisor/auth_queue | Accept: application/json |

### Response
Successful retrival of list of changes need supervisor authentication.
```json
{
    "status": 200,
    "breakdown": [
        // List of breakdown status objects
    ]
}
```

---

## Find Status Record

Finds a single record based on the provided ID.

| Method | URI | Headers |
| : |   :   | : |
| GET | /api/supervisor/auth_queue/find/{id} | Accept: application/json |

### Response
Success with data
```json
{
    "status": 200,
    "breakdown": {
        // Breakdown status details
    }
}
```

## Authorize Breakdown Status

Autorize a specific stataus record by ID.

| Method | URI | Headers |
| : |   :   | : |
| PUT | /api/supervisor/auth/{id} | Accept: application/json |

### Response
Success with data
```json
{
    "status": 200,
    "message": "Authorization Success"
}
```

Couldn't find status reprented by the provided id.
Possibly deleted invalid status id
```json
{
    "status": 204,
    "message": "No status for provided status id"
}
```

---

# Error Handling
Proper error responses will be returned in case of validation errors, authentication failures, or other issues. Ensure to handle these responses accordingly.