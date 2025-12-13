# Contribution Calendar Library

A flexible, interactive JavaScript library for creating GitHub-style contribution calendars with support for external data sources.

## Features

- 📊 **Flexible Data Format**: Support for 2-column (date, count) or 3-column (date, count, total) data
- 🎨 **10 Color Themes**: GitHub, Monochrome, Blue, Purple, Halloween, and more
- 🔌 **External Data Support**: Load from JSON, CSV, databases, or localStorage
- 📱 **Responsive Design**: Works on all screen sizes
- 🎯 **Interactive**: Tooltips, hover effects, and click handlers
- ⚡ **Easy to Use**: Simple API with sensible defaults

## Data Format

The library supports flexible data formats:

### Basic Format (2 columns)
```json
[
  { "date": "2025-01-01", "count": 5 },
  { "date": "2025-01-02", "count": 8 }
]
```

### Extended Format (3 columns with totals)
```json
[
  { "date": "2025-01-01", "count": 5, "total": 125.50 },
  { "date": "2025-01-02", "count": 8, "total": 342.75 }
]
```

### Field Mapping
The library automatically normalizes different field names:
- **date**: `date`, `day`, `timestamp`
- **count**: `count`, `value`, `quantity`
- **total**: `total`, `amount`, `sales`, `revenue`

## Usage

### Basic Example
```javascript
const calendar = new ContributionCalendar('#calendar-container', {
    data: myData,
    year: 2025,
    theme: 'github'
});
```

### Sales Dashboard Example
```javascript
const calendar = new ContributionCalendar('#calendar-container', {
    data: salesData, // [{date, count, total}]
    year: 2025,
    theme: 'blue',
    labels: {
        count: 'orders',
        total: 'revenue',
        currency: '$'
    }
});
```

### Loading External Data
```javascript
// From JSON file
const data = await CalendarDataLoader.fromJSON('data.json');
calendar.loadData(data);

// From database (via API)
const data = await CalendarDataLoader.fromDatabase({ 
    type: 'sales', 
    year: 2025 
});
calendar.loadData(data);

// From localStorage
const data = CalendarDataLoader.fromLocalStorage('my-calendar-data');
calendar.loadData(data);
```

### Dynamic Theme Switching
```javascript
calendar.setTheme('monochrome');
calendar.setTheme('purple');
```

### Custom Colors
```javascript
calendar.setColors({
    empty: '#f0f0f0',
    levels: ['#color1', '#color2', '#color3', '#color4']
});
```

## API Reference

### Constructor Options
- `data` (Array): Calendar data
- `year` (Number): Year to display
- `theme` (String): Color theme name
- `colors` (Object): Custom color scheme
- `cellSize` (Number): Cell size in pixels
- `cellGap` (Number): Gap between cells
- `showTooltip` (Boolean): Show tooltips on hover
- `onClick` (Function): Click handler for cells
- `labels` (Object): Custom labels for display

### Methods
- `updateData(data)`: Update calendar with new data
- `loadData(source)`: Load data from external source
- `setTheme(themeName)`: Change color theme
- `setColors(colors)`: Set custom colors
- `destroy()`: Remove calendar from DOM

### Static Methods
- `ContributionCalendar.getAvailableThemes()`: Get list of available themes
- `ContributionCalendar.THEMES`: Access theme definitions

## Data Loader Utilities

### CalendarDataLoader Methods
- `fromJSON(url)`: Load from JSON file
- `fromCSV(url)`: Load from CSV file
- `fromDatabase(query)`: Load from database
- `fromLocalStorage(key)`: Load from localStorage
- `toLocalStorage(key, data)`: Save to localStorage
- `filterByDateRange(data, start, end)`: Filter data by date range
- `aggregateBy(data, period)`: Aggregate data by day/week/month
- `validate(data)`: Validate data format

## Use Cases

1. **GitHub Contributions**: Track code commits and activity
2. **Sales Dashboard**: Display daily orders and revenue
3. **Fitness Tracker**: Show workout days and calories burned
4. **Habit Tracker**: Monitor daily habits and streaks
5. **Business Metrics**: Visualize any time-series data

## License

MIT License - Feel free to use in your projects!
