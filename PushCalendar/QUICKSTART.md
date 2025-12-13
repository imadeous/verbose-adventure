# Quick Start Guide

## Installation

### Step 1: Include CSS
Add the stylesheet to your HTML `<head>`:
```html
<link rel="stylesheet" href="contribution-calendar.css">
```

### Step 2: Add Container
Create a container element where the calendar will render:
```html
<div id="myCalendar"></div>
```

### Step 3: Include Scripts
Add the JavaScript files before closing `</body>`:
```html
<script src="contribution-calendar.js"></script>
<script src="data-loader.js"></script> <!-- Optional: for advanced data loading -->
```

### Step 4: Initialize Calendar
Configure and create your calendar:
```html
<script>
    // Your data
    const myData = [
        { date: '2025-01-01', count: 5 },
        { date: '2025-01-02', count: 8 },
        // ... more data
    ];

    // Configuration (just like Chart.js!)
    const config = {
        data: myData,
        year: 2025,
        theme: 'github'
    };

    // Initialize
    const calendar = new ContributionCalendar('#myCalendar', config);
</script>
```

---

## Configuration Options

### Basic Options

| Option | Type | Default | Description |
|--------|------|---------|-------------|
| `data` | Array | `[]` | Calendar data in format `[{date, count, total?}]` |
| `year` | Number | Current year | Year to display |
| `theme` | String | `'github'` | Color theme name |
| `cellSize` | Number | `12` | Cell size in pixels |
| `cellGap` | Number | `3` | Gap between cells in pixels |
| `showTooltip` | Boolean | `true` | Enable/disable tooltips |
| `onClick` | Function | `null` | Click event handler |

### Label Options

Customize display text for different contexts:

```javascript
labels: {
    count: 'orders',      // Label for count field
    total: 'revenue',     // Label for total field  
    currency: '$'         // Currency symbol
}
```

### Color Options

Use predefined themes or custom colors:

```javascript
// Using a theme
theme: 'github'  // Options: github, monochrome, blue, purple, etc.

// OR custom colors
colors: {
    empty: '#ebedf0',
    levels: ['#color1', '#color2', '#color3', '#color4']
}
```

---

## Complete Example

```html
<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="contribution-calendar.css">
</head>
<body>
    <div id="calendar"></div>

    <script src="contribution-calendar.js"></script>
    <script src="data-loader.js"></script>
    <script>
        const config = {
            data: [
                { date: '2025-01-01', count: 5, total: 125.50 },
                { date: '2025-01-02', count: 8, total: 342.75 }
            ],
            year: 2025,
            theme: 'blue',
            labels: {
                count: 'sales',
                total: 'revenue',
                currency: '$'
            },
            onClick: (day) => {
                console.log('Clicked:', day);
            }
        };

        const calendar = new ContributionCalendar('#calendar', config);
    </script>
</body>
</html>
```

---

## API Methods

### Update Data
```javascript
calendar.updateData(newData);
```

### Load External Data
```javascript
// From URL
await calendar.loadData('data.json');

// From database
const data = await CalendarDataLoader.fromDatabase({ type: 'sales', year: 2025 });
calendar.loadData(data);
```

### Change Theme
```javascript
calendar.setTheme('monochrome');
```

### Set Custom Colors
```javascript
calendar.setColors({
    empty: '#f0f0f0',
    levels: ['#color1', '#color2', '#color3', '#color4']
});
```

### Get Available Themes
```javascript
const themes = ContributionCalendar.getAvailableThemes();
// Returns: [{key: 'github', name: 'GitHub Green'}, ...]
```

### Destroy Calendar
```javascript
calendar.destroy();
```

---

## Data Format

### Simple Format (2 columns)
For basic activity tracking:
```javascript
[
    { date: '2025-01-01', count: 5 },
    { date: '2025-01-02', count: 8 }
]
```

### Extended Format (3 columns)
For financial or detailed tracking:
```javascript
[
    { date: '2025-01-01', count: 5, total: 125.50 },
    { date: '2025-01-02', count: 8, total: 342.75 }
]
```

### Flexible Field Names
The library auto-normalizes different field names:
- **date**: `date`, `day`, `timestamp`
- **count**: `count`, `value`, `quantity`
- **total**: `total`, `amount`, `sales`, `revenue`

```javascript
// These all work!
{ date: '2025-01-01', count: 5, total: 100 }
{ day: '2025-01-01', value: 5, amount: 100 }
{ timestamp: '2025-01-01', quantity: 5, revenue: 100 }
```

---

## Available Themes

1. `github` - Classic GitHub green
2. `monochrome` - Grayscale gradient
3. `blue` - Ocean blue
4. `purple` - Purple dream
5. `halloween` - Orange to dark
6. `tricolor` - Multi-color gradient
7. `sunset` - Warm orange
8. `forest` - Nature green
9. `fire` - Red/orange
10. `ice` - Cool blue
11. `temperature` - Heatmap style

---

## Advanced: Loading External Data

### From JSON File
```javascript
const data = await CalendarDataLoader.fromJSON('data.json');
calendar.loadData(data);
```

### From API Endpoint
```javascript
const data = await CalendarDataLoader.fromJSON('https://api.example.com/calendar-data');
calendar.loadData(data);
```

### From localStorage
```javascript
const data = CalendarDataLoader.fromLocalStorage('myCalendarData');
calendar.loadData(data);
```

### Save to localStorage
```javascript
CalendarDataLoader.toLocalStorage('myCalendarData', myData);
```

### Filter by Date Range
```javascript
const filtered = CalendarDataLoader.filterByDateRange(
    myData,
    '2025-01-01',
    '2025-06-30'
);
```

### Aggregate Data
```javascript
// Aggregate by week or month
const aggregated = CalendarDataLoader.aggregateBy(myData, 'week');
```

---

## Use Cases

✅ GitHub-style contribution tracking  
✅ E-commerce sales dashboards  
✅ Fitness/habit trackers  
✅ Project activity monitoring  
✅ Customer engagement analytics  
✅ Content publishing calendars  
✅ Support ticket visualization  
✅ Any time-series activity data  

---

## Browser Support

Works in all modern browsers:
- Chrome/Edge (latest)
- Firefox (latest)
- Safari (latest)
- Opera (latest)

Requires ES6+ support.

---

## License

MIT License - Free for personal and commercial use!
