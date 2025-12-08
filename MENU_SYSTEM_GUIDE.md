# Menu Management System - Installation & Usage

## Overview
A complete menu management system with drag-and-drop reordering, conditional fields, and sidebar integration.

## Installation Steps

### 1. Install VueDraggable
Since terminal commands are not working, you'll need to manually add this to your `package.json`:

```json
{
  "dependencies": {
    "vuedraggable": "^4.1.0"
  }
}
```

Then run: `npm install` (when terminal is available)

### 2. Files Created

#### Backend (Laravel):
- `app/Http/Controllers/MenuController.php` - Full CRUD + reorder endpoint
- Routes added to `routes/web.php`:
  - GET `/admin/menus` - List menus
  - POST `/admin/menus` - Create menu
  - PUT `/admin/menus/{menu}` - Update menu
  - DELETE `/admin/menus/{menu}` - Delete menu
  - POST `/admin/menus/reorder` - Reorder menus (drag & drop)

#### Frontend (Vue):
- `resources/js/pages/Admin/Menus/Index.vue` - Main page with draggable table
- `resources/js/pages/Admin/Menus/MenuModal.vue` - Form with conditional fields

## Features Implemented

### 1. Drag and Drop Reordering
- Uses `vuedraggable` library
- Drag handle icon for each menu item
- Automatically saves new order to database
- Visual feedback during dragging

### 2. Conditional Fields (Matching Filament Logic)

#### Basic Information:
- **Title** (required)
- **Type** (required): Page or Custom
  - If "Page": Shows page selector
  - If "Custom": Shows URL input field

#### Dropdown Configuration:
- **Has Dropdown** (toggle)
  - If enabled, shows:
    - **Child Type**: Pages or Components
      - If "Pages": Shows multi-select for pages
      - If "Components": Shows component selector (Projects, Blogs, Services, Events)

### 3. Field Clearing Logic
- When type changes: Clears irrelevant fields (page_id or url)
- When has_children is disabled: Clears child_type, component, and pages
- When child_type changes: Clears component or pages based on selection

### 4. Search Functionality
- Search by menu title
- Preserves state and scroll position

## Usage

### Access the Menu Management
Navigate to: `/admin/menus`

### Creating a Menu Item
1. Click "Create Menu Item"
2. Fill in the title
3. Select type (Page or Custom)
4. Configure dropdown settings if needed
5. Click "Create"

### Reordering Menus
1. Click and hold the grip icon (⋮⋮) on the left of any menu item
2. Drag to desired position
3. Release - order is automatically saved

### Editing/Deleting
- Click "Edit" to modify a menu item
- Click "Delete" to remove (with confirmation)

## Database Structure

The `menus` table should have these columns:
- `id`
- `title`
- `type` (page/custom)
- `page_id` (nullable, foreign key to pages)
- `url` (nullable)
- `has_children` (boolean)
- `child_type` (nullable: pages/components)
- `component` (nullable)
- `order` (integer)
- `timestamps`

Plus a pivot table `menu_page` for many-to-many relationship with pages.

## Next Steps

### 1. Add to Sidebar Navigation
Add this to your sidebar component:

```vue
<Link href="/admin/menus" class="sidebar-link">
    <Menu class="h-4 w-4" />
    <span>Menus</span>
</Link>
```

### 2. Frontend Menu Rendering
Create a component to render the menus on the frontend based on the menu data.

### 3. Nested Menus (Optional Enhancement)
If you need nested/hierarchical menus, you can extend the system to support parent-child relationships using the `parent_id` field.

## Troubleshooting

### VueDraggable Not Working
- Ensure `vuedraggable` is installed: `npm install vuedraggable@^4.1.0`
- Check that the import is correct: `import draggable from 'vuedraggable'`
- Verify Vue 3 compatibility (version 4.x of vuedraggable)

### Menus Not Saving Order
- Check browser console for errors
- Verify the `/admin/menus/reorder` route is accessible
- Ensure the MenuController `reorder` method is working

### Conditional Fields Not Showing
- Check browser console for Vue warnings
- Verify the `watch` functions are working
- Ensure form data is reactive
