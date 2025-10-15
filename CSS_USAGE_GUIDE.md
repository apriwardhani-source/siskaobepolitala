# 🎨 SISKA OBE - CSS Design System Guide

## 📍 File Location
**CSS File**: `public/css/custom-styles.css`

## 🔗 Already Linked in Layouts
✅ `resources/views/layouts/app.blade.php` (Admin)
✅ `resources/views/layouts/tim/app.blade.php` (Tim/Admin Prodi)

Semua halaman otomatis menggunakan style yang sama!

---

## 🎯 Quick Reference

### 🔘 Buttons

```html
<!-- Primary Button (Blue) -->
<button class="btn-gradient-primary">
    <svg class="w-5 h-5 mr-2">...</svg>
    Tambah Data
</button>

<!-- Success Button (Green) -->
<button class="btn-gradient-success">
    <svg class="w-5 h-5 mr-2">...</svg>
    Simpan
</button>

<!-- Danger Button (Red) -->
<button class="btn-gradient-danger">
    <svg class="w-5 h-5 mr-2">...</svg>
    Hapus
</button>
```

### 📦 Cards

```html
<!-- Modern Card -->
<div class="card-modern">
    <div class="card-header-gradient">
        <h2>Title Here</h2>
    </div>
    <div class="p-6">
        Content here
    </div>
</div>

<!-- Stats Card -->
<div class="card-stats blue">
    <div class="flex items-center justify-between">
        <div>
            <p class="text-gray-600 text-sm">Total CPL</p>
            <h3 class="text-3xl font-bold">9</h3>
        </div>
        <div class="icon-gradient blue">
            <svg>...</svg>
        </div>
    </div>
</div>

<!-- Available colors: blue, green, amber, red -->
```

### 🏷️ Badges

```html
<!-- Modern Badges -->
<span class="badge-modern badge-blue">Active</span>
<span class="badge-modern badge-green">Success</span>
<span class="badge-modern badge-amber">Warning</span>
<span class="badge-modern badge-red">Error</span>
<span class="badge-modern badge-purple">Info</span>
<span class="badge-modern badge-gray">Default</span>
```

### 🚨 Alerts

```html
<!-- Success Alert -->
<div class="alert-modern alert-success">
    <svg class="w-6 h-6 mr-3">...</svg>
    <div>
        <h3 class="text-sm font-semibold">Berhasil!</h3>
        <p class="text-sm">Data berhasil disimpan</p>
    </div>
</div>

<!-- Other types: alert-error, alert-warning, alert-info -->
```

### 📊 Tables

```html
<table class="table-modern">
    <thead>
        <tr>
            <th>No</th>
            <th>Nama</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>1</td>
            <td>Data</td>
            <td>Actions</td>
        </tr>
    </tbody>
</table>

<!-- Hover effects & striped rows automatically applied -->
```

### 📝 Forms

```html
<!-- Modern Input -->
<input type="text" class="input-modern" placeholder="Enter text...">

<!-- Modern Select -->
<select class="select-modern">
    <option>Select option</option>
</select>
```

### 🎨 Icon Containers

```html
<div class="icon-gradient blue">
    <svg class="w-8 h-8 text-white">...</svg>
</div>

<!-- Available colors: blue, green, amber, red -->
```

### 📭 Empty State

```html
<div class="empty-state">
    <svg class="empty-state-icon">...</svg>
    <h3 class="empty-state-title">No Data Found</h3>
    <p class="empty-state-text">
        There are no items to display at this time.
    </p>
</div>
```

### 📈 Progress Bar

```html
<div class="progress-bar">
    <div class="progress-fill green" style="width: 75%"></div>
</div>

<!-- Colors: green, amber, red -->
```

### 💫 Animations

```html
<!-- Fade In -->
<div class="animate-fade-in">Content</div>

<!-- Slide In -->
<div class="animate-slide-in">Content</div>

<!-- Hover Effects -->
<div class="hover-lift">Lifts on hover</div>
<div class="hover-scale">Scales on hover</div>
```

### 🔧 Utility Classes

```html
<!-- Shadows -->
<div class="shadow-modern">Regular shadow</div>
<div class="shadow-modern-lg">Large shadow</div>

<!-- Borders & Corners -->
<div class="border-modern rounded-modern">Content</div>

<!-- Text Gradient -->
<h1 class="text-gradient">Gradient Text</h1>

<!-- Sticky Elements -->
<div class="sticky-header">Sticky header</div>
<div class="sticky-column">Sticky column</div>
```

---

## 🎨 Color Palette

### Primary Colors
- **Blue**: Primary actions, links
- **Green**: Success, approve actions
- **Amber**: Warnings, pending states
- **Red**: Errors, delete actions
- **Purple**: Special status, role badges
- **Gray**: Neutral, disabled states

### Gradients
All buttons and headers use gradient backgrounds for modern look:
- Primary: Blue gradient (from-blue-600 to-blue-700)
- Success: Green gradient (from-green-600 to-green-700)
- Danger: Red gradient (from-red-600 to-red-700)
- Headers: Gray gradient (from-gray-700 to-gray-800)

---

## 📐 Layout Patterns

### Standard Page Layout
```html
<div class="min-h-screen bg-gradient-to-br from-gray-50 to-gray-100 py-6 px-4 sm:px-6 lg:px-8">
    <div class="max-w-7xl mx-auto">
        
        <!-- Header -->
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-900">Page Title</h1>
            <p class="text-sm text-gray-600">Description</p>
        </div>

        <!-- Main Card -->
        <div class="bg-white rounded-xl shadow-lg overflow-hidden border border-gray-200">
            <!-- Content -->
        </div>
    </div>
</div>
```

### Toolbar Pattern
```html
<div class="px-6 py-5 border-b border-gray-200 bg-white">
    <div class="flex items-center justify-between">
        <h2 class="text-lg font-semibold text-gray-900">Section Title</h2>
        
        <!-- Search or Filter -->
        <div class="w-80">
            <input type="text" class="input-modern" placeholder="Search...">
        </div>
    </div>
</div>
```

---

## 🚀 Migration Tips

### Converting Existing Pages

**Before:**
```html
<button class="bg-blue-500 hover:bg-blue-700 text-white px-4 py-2 rounded">
    Button
</button>
```

**After:**
```html
<button class="btn-gradient-primary">
    Button
</button>
```

**Before:**
```html
<span class="bg-blue-100 text-blue-800 px-2 py-1 rounded-full text-xs">
    Status
</span>
```

**After:**
```html
<span class="badge-modern badge-blue">Status</span>
```

---

## 📱 Responsive Design

All components are mobile-first and responsive:
- Buttons become full-width on mobile
- Tables scroll horizontally
- Cards stack vertically
- Toolbars adapt to smaller screens

---

## 🎭 Advanced Features

### Tooltip
```html
<span class="tooltip">
    Hover me
    <span class="tooltip-content">Tooltip text</span>
</span>
```

### Modal
```html
<div class="modal-overlay">
    <div class="modal-content">
        <h2>Modal Title</h2>
        <p>Content</p>
    </div>
</div>
```

### Loading Spinner
```html
<div class="spinner"></div>
```

---

## 💡 Best Practices

1. **Consistency**: Always use provided classes instead of inline Tailwind
2. **Accessibility**: Include proper ARIA labels and alt text
3. **Animations**: Use provided animation classes for smooth transitions
4. **Colors**: Stick to the defined color palette
5. **Spacing**: Use consistent padding/margin (px-6 py-4 pattern)

---

## 🔄 Auto-Applied Styles

These work automatically on all pages:
✅ Table hover effects
✅ Button transitions
✅ Card shadows
✅ Form focus states
✅ Alert animations
✅ Responsive breakpoints

---

## 🛠️ Customization

To modify styles, edit: `public/css/custom-styles.css`

After changes:
```bash
php artisan view:clear
```

---

**🎉 All 20+ pages now use this unified design system!**
