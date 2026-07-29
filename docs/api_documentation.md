# REST API Documentation - YouTube-like Video Sharing Platform

## Base URL
`http://localhost:8000/api/v1`

---

## 1. Authentication Endpoints

### Register User
- **POST** `/auth/register`
- **Headers**: `Content-Type: application/json`, `Accept: application/json`
- **Body**:
```json
{
  "first_name": "John",
  "last_name": "Doe",
  "email": "john@example.com",
  "phone": "9876543210",
  "password": "password123",
  "password_confirmation": "password123"
}
```
- **Response (201 Created)**:
```json
{
  "status": "success",
  "message": "Registration successful",
  "data": {
    "user": { "id": 1, "email": "john@example.com", "full_name": "John Doe" },
    "token": "1|sanctum_token_string"
  }
}
```

### Login
- **POST** `/auth/login`
- **Body**:
```json
{
  "email": "john@example.com",
  "password": "password123"
}
```
- **Response (200 OK)**:
```json
{
  "status": "success",
  "message": "Login successful",
  "data": {
    "user": { "id": 1, "email": "john@example.com", "role": "user" },
    "token": "2|sanctum_token_string"
  }
}
```

### Logout
- **POST** `/auth/logout`
- **Headers**: `Authorization: Bearer <TOKEN>`
- **Response (200 OK)**:
```json
{
  "status": "success",
  "message": "Logged out successfully"
}
```

---

## 2. Profile Management

### Get Current User Profile
- **GET** `/profile`
- **Headers**: `Authorization: Bearer <TOKEN>`

### Update Profile
- **PUT** `/profile`
- **Body**:
```json
{
  "first_name": "John",
  "last_name": "Doe",
  "username": "johndoe",
  "bio": "Tech enthusiast and video creator",
  "website": "https://johndoe.com"
}
```

---

## 3. Video Management

### List Public Videos
- **GET** `/videos?page=1&category_id=1&sort=latest`

### Get Single Video Details
- **GET** `/videos/{slug}`

### Upload Video
- **POST** `/videos`
- **Headers**: `Authorization: Bearer <TOKEN>`, `Content-Type: multipart/form-data`
- **Form Data**:
  - `title`: "My New Vlog"
  - `description`: "Check out my latest trip!"
  - `category_id`: 1
  - `video_file`: (binary video file)
  - `thumbnail`: (binary image file)
  - `visibility`: "public"
  - `allow_downloads`: true

### Like / Dislike Video
- **POST** `/videos/{id}/like`
- **Headers**: `Authorization: Bearer <TOKEN>`
- **Body**: `{ "type": "like" }` or `{ "type": "dislike" }`

---

## 4. Comments & Replies

### List Video Comments
- **GET** `/videos/{videoId}/comments?page=1`

### Add Comment
- **POST** `/videos/{videoId}/comments`
- **Headers**: `Authorization: Bearer <TOKEN>`
- **Body**: `{ "body": "Awesome video!", "parent_id": null }`

### Like Comment
- **POST** `/comments/{id}/like`
- **Headers**: `Authorization: Bearer <TOKEN>`

---

## 5. Subscriptions

### Toggle Subscribe Channel
- **POST** `/subscriptions`
- **Headers**: `Authorization: Bearer <TOKEN>`
- **Body**: `{ "creator_id": 2 }`

### Get Subscriptions Feed
- **GET** `/subscriptions/subscriptions`
- **Headers**: `Authorization: Bearer <TOKEN>`

---

## 6. Playlists & Watch History

### List User Playlists
- **GET** `/playlists`
- **Headers**: `Authorization: Bearer <TOKEN>`

### Create Playlist
- **POST** `/playlists`
- **Body**: `{ "title": "Favorites 2026", "visibility": "public" }`

### Add Video to Playlist
- **POST** `/playlists/{id}/videos`
- **Body**: `{ "video_id": 10 }`

### Get Watch History
- **GET** `/history`
- **Headers**: `Authorization: Bearer <TOKEN>`

---

## 7. Search & Notifications

### Search Videos
- **GET** `/search?q=laravel&category_id=2&sort=latest`

### Get User Notifications
- **GET** `/notifications`
- **Headers**: `Authorization: Bearer <TOKEN>`
