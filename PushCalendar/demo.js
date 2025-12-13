/**
 * Demo file - Shows how to use the ContributionCalendar library
 */

// Generate some sample data
function generateSampleData() {
    const data = [];
    const year = 2025;

    // Generate random contributions for the year
    for (let month = 0; month < 12; month++) {
        const daysInMonth = new Date(year, month + 1, 0).getDate();

        for (let day = 1; day <= daysInMonth; day++) {
            // Random chance of having contributions
            if (Math.random() > 0.3) {
                const date = new Date(year, month, day);
                const dateStr = `${year}-${String(month + 1).padStart(2, '0')}-${String(day).padStart(2, '0')}`;

                // Random contribution count (0-15)
                const count = Math.floor(Math.random() * 16);

                data.push({
                    date: dateStr,
                    count: count
                });
            }
        }
    }

    return data;
}

// Initialize the calendar when the page loads
document.addEventListener('DOMContentLoaded', () => {
    // Start with basic contribution data
    const sampleData = generateSampleData();

    // Create the calendar with default theme
    const calendar = new ContributionCalendar('#calendar-container', {
        data: sampleData,
        year: 2025,
        cellSize: 12,
        cellGap: 3,
        theme: 'github',
        showTooltip: true,
        labels: {
            count: 'contributions',
            total: 'total',
            currency: '$'
        },
        onClick: (day) => {
            console.log('Clicked on:', day);
            const message = day.total
                ? `Date: ${day.dateStr}\nCount: ${day.count}\nTotal: $${day.total.toFixed(2)}`
                : `Date: ${day.dateStr}\nContributions: ${day.count}`;
            alert(message);
        }
    });

    // Create theme selector
    createThemeSelector(calendar);

    // Create data source selector
    createDataSourceSelector(calendar);

    console.log('Contribution calendar initialized!');
    console.log('Total data points:', sampleData.length);
    console.log('Available themes:', ContributionCalendar.getAvailableThemes());
});

/**
 * Create a theme selector UI
 */
function createThemeSelector(calendar) {
    const container = document.getElementById('calendar-container');

    // Create selector wrapper
    const selectorWrapper = document.createElement('div');
    selectorWrapper.className = 'theme-selector';

    const label = document.createElement('label');
    label.textContent = 'Color Theme: ';
    label.className = 'theme-label';

    const select = document.createElement('select');
    select.className = 'theme-dropdown';

    // Add theme options
    const themes = ContributionCalendar.getAvailableThemes();
    themes.forEach(theme => {
        const option = document.createElement('option');
        option.value = theme.key;
        option.textContent = theme.name;
        if (theme.key === 'github') {
            option.selected = true;
        }
        select.appendChild(option);
    });

    // Add change event
    select.addEventListener('change', (e) => {
        calendar.setTheme(e.target.value);
    });

    selectorWrapper.appendChild(label);
    selectorWrapper.appendChild(select);

    // Insert before the calendar
    container.insertBefore(selectorWrapper, container.firstChild);
}

/**
 * Create a data source selector to demonstrate external data loading
 */
function createDataSourceSelector(calendar) {
    const container = document.getElementById('calendar-container');

    // Create selector wrapper
    const selectorWrapper = document.createElement('div');
    selectorWrapper.className = 'theme-selector';

    const label = document.createElement('label');
    label.textContent = 'Data Source: ';
    label.className = 'theme-label';

    const select = document.createElement('select');
    select.className = 'theme-dropdown';

    // Add data source options
    const sources = [
        { value: 'contributions', label: 'GitHub Contributions (2 columns)' },
        { value: 'sales', label: 'Daily Sales (3 columns: date, orders, total)' },
        { value: 'orders', label: 'Order Activity (3 columns: date, count, revenue)' }
    ];

    sources.forEach(source => {
        const option = document.createElement('option');
        option.value = source.value;
        option.textContent = source.label;
        select.appendChild(option);
    });

    // Add loading indicator
    const loadingIndicator = document.createElement('span');
    loadingIndicator.className = 'loading-indicator';
    loadingIndicator.style.display = 'none';
    loadingIndicator.textContent = ' Loading...';

    // Add change event
    select.addEventListener('change', async (e) => {
        loadingIndicator.style.display = 'inline';
        select.disabled = true;

        try {
            let data;
            const sourceType = e.target.value;

            // Simulate loading from different sources
            if (sourceType === 'sales') {
                // Load sales data with totals
                data = await CalendarDataLoader.fromDatabase({ type: 'sales', year: 2025 });
                calendar.config.labels = {
                    count: 'orders',
                    total: 'sales',
                    currency: '$'
                };
            } else if (sourceType === 'orders') {
                // Load order data with revenue
                data = await CalendarDataLoader.fromDatabase({ type: 'sales', year: 2025 });
                calendar.config.labels = {
                    count: 'orders',
                    total: 'revenue',
                    currency: '$'
                };
            } else {
                // Load basic contributions (no total)
                data = await CalendarDataLoader.fromDatabase({ type: 'contributions', year: 2025 });
                calendar.config.labels = {
                    count: 'contributions',
                    total: 'total',
                    currency: '$'
                };
            }

            // Update calendar with new data
            await calendar.loadData(data);

            console.log(`Loaded ${data.length} records from ${sourceType} source`);
            console.log('Sample data:', data.slice(0, 3));

        } catch (error) {
            console.error('Error loading data:', error);
            alert('Error loading data. Check console for details.');
        } finally {
            loadingIndicator.style.display = 'none';
            select.disabled = false;
        }
    });

    selectorWrapper.appendChild(label);
    selectorWrapper.appendChild(select);
    selectorWrapper.appendChild(loadingIndicator);

    // Insert after theme selector
    const themeSelector = container.querySelector('.theme-selector');
    if (themeSelector && themeSelector.nextSibling) {
        container.insertBefore(selectorWrapper, themeSelector.nextSibling);
    } else {
        container.insertBefore(selectorWrapper, container.firstChild);
    }
}
