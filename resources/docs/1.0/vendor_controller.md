# Introduction

APIs to interact with vendor data, allowing users to perform CRUD (Create, Read, Update, Delete) operations on vendor records.

## Base URL

All endpoints are relative to the base URL of your Laravel application.

---

# Authentication

To access these endpoints, authentication is required. Use appropriate tokens or authentication mechanisms to access the endpoints.

> to authnticate the request every request should be bind with  `bearer token`

> Admin authentication is required for CREATE, UPDATE and DELETE endpoints.

> FND and VIEW endpoints require auth token of any user level.

---

# Endpoints

## Create Vendor
Creates a new vendor.

| Method | URI | Headers |
| : |   :   | : |
| POST | /api/vendor/create | Accept: application/json |

### Request Body
```json
{
    "name": "string",
    "main_email": "string (email)",
    "cc_email_1": "string (email)",
    "cc_email_2": "string (email)",
    "cc_email_3": "string (email)",
    "contact_1": "string",
    "contact_2": "string",
    "address": "string"
}
```

### Response
Successful create of vendor
```json
{
    "status": 201,
    "message": "Vendor Create Success",
    "user": {
        // Vendor details
    }
}
```

---

## Retrieve Vendors

Retrieves a list of all vendors.

| Method | URI | Headers |
| : |   :   | : |
| GET | /api/vendor/view | Accept: application/json |

### Response
Success with data
```json
{
    "status": 200,
    "vendor": [
        // List of vendor objects
    ]
}
```

## Find Vendor

Retrieves a specific vendor by ID.

| Method | URI | Headers |
| : |   :   | : |
| GET | /api/vendor/view/{id} | Accept: application/json |

### Response
Success with data
```json
{
    "status": 200,
    "vendor": {
        // Vendor details
    }
}
```

Success With No data
```json
{
    "status": 204,
    "message": "No vendor for provided vendor id"
}
```

---

## Update Vendor
Updates an existing vendor by ID.

| Method | URI | Headers |
| : |   :   | : |
| PUT | /api/vendor/view/{id} | Accept: application/json |

### Request Body

```json
{
    // Updated vendor details
    // similer to create request body but feilds are optional
}
```

### Response
Sucessful update of vendor.

```json
{
    "status": 200,
    "message": "Vendor Updated Success",
    "vendor": {
        // Updated vendor details
    }
}
```

Couldn't find vendor reprented by the provided id.
Possibly deleted vendor/ invalid vendor id
```json
{
    "status": 204,
    "message": "No vendor for provided vendor id"
}
```

---

## Delete Vendor

Deletes a specific vendor by ID.

| Method | URI | Headers |
| : |   :   | : |
| DELETE | /api/vendor/delete/{id} | Accept: application/json |

> {danger.fa-lightbulb} Deletes performed by this controller are soft deletes.

### Response
Sucessful update of vendor.

```json
{
    "status": 200,
    "message": "Vendor delete success",
    "user": {
        // Deleted vendor details
    }
}
```

Couldn't find vendor reprented by the provided id.
Possibly deleted vendor/ invalid vendor id
```json
{
    "status": 204,
    "message": "No vendor for provided vendor id"
}
```

---

# Error Handling
Proper error responses will be returned in case of validation errors, authentication failures, or other issues. Ensure to handle these responses accordingly.