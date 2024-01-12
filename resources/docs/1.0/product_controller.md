- [Introduction](#Introduction-link)
- [Authentication](#Authentication-link)
- [Endpoint](#Endpoint-link)
- [Models Used](#Models-link)
- [Error Handling](#Error-link)

<a name="Introduction-link">
# [Introduction](#Introduction-link)

> The `ProductController` manages CRUD operations for products in the system. This documentation outlines the available endpoints, their functionalities, request body structures, and the overall usage of this controller.

## Base URL

All endpoints are relative to the base URL of your Laravel application.

---

<a name="Authentication-link">
# [Authentication](#Authentication-link)

To access these endpoints, authentication is required. Use appropriate tokens or authentication mechanisms to access the endpoints.

> to authnticate the request every request should be bind with  `bearer token`
> Admin Authentication required for CREATE, UPDATE and DELETE Endpoints.
> RETRIVE, FIND, RETRIVE_BY_VENDOR endpoints can be requested by any user role.

---

<a name="Endpoint-link">
# [Endpoint](#Endpoint-link)
> 

## Create Product

Creates a new product entry in the system.

| Method | URI | Headers |
| : |   :   | : |
| POST | /api/product/create | Accept: application/json |

### Request Body

```json
{
    "name": "string", // Required: The name of the product
    "vendor": "integer (vendor ID)", // Required: The ID of the associated vendor
    "connection_type": "string ('PSTN' or 'GPRS')", // Optional: Type of connection
    "description": "string" // Optional: Description of the product
}
```

### Response
Successful insert

```json
{
    "status": 201,
    "message": "Product created successfully",
    "product": {
        // Product Details
    }
}

```

##  Retrieve All Products

Retrieves a list of all products available.

| Method | URI | Headers |
| : |   :   | : |
| GET | /api/product/view | Accept: application/json |

### Response

```json
{
    "status": 200,
    "products": [
        // List of product objects
    ]
}

```

## Find Product by ID
Retrieves a specific status by ID.

| Method | URI | Headers |
| : |   :   | : |
| GET | /api/product/view/{id} | Accept: application/json |

### Response
Successful find
```json
{
    "status": 200,
    "product": {
        // product details
    }
}
```
No Data
```json
{
    "status": 204,
    "message": "No product for provided product id"
}
```

## Retrieve Products by Vendor ID
Retrieves a specific status by ID.

| Method | URI | Headers |
| : |   :   | : |
| GET | /api/product/view/byvendor/{vendor_id}` | Accept: application/json |

### Response
Successful find
```json
{
    "status": 200,
    "products": [
        // List of product objects
    ]
}
```

## Update Product

Updates an existing status record.

| Method | URI | Headers |
| : |   :   | : |
| PUT | /api/product/update/{id} | Accept: application/json |

### Reques Body

```json
{
    "name": "string", // Required: The name of the product
    "vendor": "integer (vendor ID)", // Required: The ID of the associated vendor
    "connection_type": "string ('PSTN' or 'GPRS')", // Optional: Type of connection
    "description": "string" // Optional: Description of the product
}
```

### Response
Successful Update
```json
{
    "status": 200,
    "message": "Product Updated Success",
    "product": {
        //Updated product details
    }
}
```

Failed Attempt
```json
{
    "status": 204,
    "message": "No product for provided product id"
}
```

## Delete Product
Deletes a specific product by ID.


| Method | URI | Headers |
| : |   :   | : |
| DELETE | /api/product/delete/{id} | Accept: application/json |

### Response
Successful Delete
```json
{
    "status": 200,
    "message": "Product delete success"
}
```

No Data
```json
{
    "status": 204,
    "message": "No product for provided product id"
}
```

---
<a name="Models-link">
# [Models Used](#Models-link)
> 
## Product Model
The Product model represents the product entities in the system. It includes fields such as name, vendor, connection_type, and description. It is associated with the Vendor model.

## Vendor Model
The Vendor model represents the vendors or suppliers associated with products. It might include fields like name, email, contact_1, contact_2, and address.

---

<a name="Error-link">
# [Error Handling](#Error-link)

Proper error responses will be returned in case of validation errors, authentication failures, or other issues. Ensure to handle these responses accordingly.