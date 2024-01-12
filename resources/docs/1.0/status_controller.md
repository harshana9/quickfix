- [Introduction](#Introduction-link)
- [Authentication](#Authentication-link)
- [Endpoint](#Endpoint-link)
- [Models Used](#Models-link)
- [Error Handling](#Error-link)

<a name="Introduction-link">
# [Introduction](#Introduction-link)

> The Status Controller manages the creation, retrieval, updating, and deletion of status records in the system. This documentation outlines the available endpoints and their functionalities.

## Base URL

All endpoints are relative to the base URL of your Laravel application.

---

<a name="Authentication-link">
# [Authentication](#Authentication-link)

To access these endpoints, authentication is required. Use appropriate tokens or authentication mechanisms to access the endpoints.

> to authnticate the request every request should be bind with  `bearer token`

> 'User' auth can make the request

---

<a name="Endpoint-link">
# [Endpoint](#Endpoint-link)
> 

## Insert Status

Inserts a new status record into the system.

| Method | URI | Headers |
| : |   :   | : |
| POST | /api/status/create | Accept: application/json |

### Request Body

```json
{
    "status_name": "string",
    "description": "string",
    "auth_required": "boolean"
}
```

### Response
Successful insert

```json
{
    "status": 201,
    "message": "Status Create Success"
}
```

## View Status

Retrieves all status records.

| Method | URI | Headers |
| : |   :   | : |
| GET | /api/status/view | Accept: application/json |

### Response

```json
{
    "status": 200,
    "statuses": [
        // List of status objects
    ]
}

```

## Find Status
Retrieves a specific status by ID.

| Method | URI | Headers |
| : |   :   | : |
| GET | /api/status/view/{id} | Accept: application/json |

### Response
Successful find
```json
{
    "status": 200,
    "status": {
        // Status details
    }
}
```
No Data
```json
{
    "status": 204,
    "message": "No status for provided status id"
}
```

## Update Status

Updates an existing status record.

| Method | URI | Headers |
| : |   :   | : |
| PUT | /api/status/update/{id} | Accept: application/json |

### Reques Body

```json
{
    "status_name": "string",
    "description": "string",
    "auth_required": "boolean"
}
```

### Response
Successful Update
```json
{
    "status": 200,
    "message": "Status Updated Success"
}
```

## Delete Status
Deletes a specific status by ID.


| Method | URI | Headers |
| : |   :   | : |
| DELETE | /api/status/delete/{id} | Accept: application/json |

### Response
Successful Delete
```json
{
    "status": 200,
    "message": "Status delete success"
}
```

No Data
```json
{
    "status": 204,
    "message": "No status for provided status id"
}
```

---
<a name="Models-link">
# [Models Used](#Models-link)

## Breakdown Model

The `Breakdown` model represents information related to breakdown records in the system. It is utilized in various parts of the application to store details about breakdown occurrences.

- **Relationships:**
  - `product()`: BelongsTo relationship with the `Product` model.

## BreakdownStatus Model

The `BreakdownStatus` model manages statuses and authorization queues for breakdown records within the application.

- **Relationships:**
  - `breakdown()`: BelongsTo relationship with the `Breakdown` model.
  - `user()`: BelongsTo relationship with the `User` model.
  - `status()`: BelongsTo relationship with the `Status` model.
  - `authorize()`: BelongsTo relationship with the `User` model representing authorization.

## Status Model

The `Status` model handles different statuses used within the system.

This information gives a high-level overview of the attributes and relationships associated with each of the models used in the Status Controller.

---

<a name="Error-link">
# [Error Handling](#Error-link)

Proper error responses will be returned in case of validation errors, authentication failures, or other issues. Ensure to handle these responses accordingly.