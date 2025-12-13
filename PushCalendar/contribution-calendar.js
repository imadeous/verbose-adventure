/**
 * ContributionCalendar - A GitHub-style contribution calendar library
 * 
 * This library allows you to create interactive contribution calendars
 * similar to GitHub's activity grid.
 */

class ContributionCalendar {
    // Color theme presets
    static THEMES = {
        github: {
            name: 'GitHub Green',
            empty: '#ebedf0',
            levels: ['#9be9a8', '#40c463', '#30a14e', '#216e39']
        },
        monochrome: {
            name: 'Monochrome',
            empty: '#ebedf0',
            levels: ['#c6c6c6', '#969696', '#636363', '#2b2b2b']
        },
        blue: {
            name: 'Ocean Blue',
            empty: '#ebedf0',
            levels: ['#9dd8fb', '#40b8f5', '#1e8bc3', '#155a8a']
        },
        purple: {
            name: 'Purple Dream',
            empty: '#ebedf0',
            levels: ['#d4b5f7', '#b084f5', '#8b5cf6', '#6d28d9']
        },
        halloween: {
            name: 'Halloween',
            empty: '#ebedf0',
            levels: ['#ffee4a', '#ffc501', '#fe9600', '#03001c']
        },
        tricolor: {
            name: 'Tri-Color Gradient',
            empty: '#ebedf0',
            levels: ['#fde68a', '#fb923c', '#f43f5e', '#be123c']
        },
        sunset: {
            name: 'Sunset',
            empty: '#ebedf0',
            levels: ['#fef08a', '#fb923c', '#f97316', '#c2410c']
        },
        forest: {
            name: 'Forest',
            empty: '#ebedf0',
            levels: ['#a7f3d0', '#34d399', '#059669', '#065f46']
        },
        fire: {
            name: 'Fire',
            empty: '#ebedf0',
            levels: ['#fed7aa', '#fb923c', '#ea580c', '#7c2d12']
        },
        ice: {
            name: 'Ice',
            empty: '#ebedf0',
            levels: ['#dbeafe', '#60a5fa', '#2563eb', '#1e3a8a']
        },
        ice: {
            name: 'Temperature',
            empty: '#ebedf0',
            levels: ['#c75735ff', '#f7d630ff', '#1e831aff', '#06492cff']
        }
    };

    constructor(container, options = {}) {
        // Store the container element
        this.container = typeof container === 'string'
            ? document.querySelector(container)
            : container;

        if (!this.container) {
            throw new Error('Container element not found');
        }

        // Get theme colors
        const themeColors = this.getThemeColors(options.theme, options.colors);

        // Default configuration
        this.config = {
            data: options.data || [],
            year: options.year || new Date().getFullYear(),
            cellSize: options.cellSize || 12,
            cellGap: options.cellGap || 3,
            theme: options.theme || 'github',
            colors: themeColors,
            showTooltip: options.showTooltip !== false,
            onClick: options.onClick || null,
            // Data field labels for display
            labels: {
                count: options.labels?.count || 'contributions',
                total: options.labels?.total || 'total',
                currency: options.labels?.currency || '$'
            }
        };

        // Initialize the calendar
        this.init();
    }

    /**
     * Get theme colors based on theme name or custom colors
     */
    getThemeColors(theme, customColors) {
        if (customColors) {
            return customColors;
        }

        if (theme && ContributionCalendar.THEMES[theme]) {
            return ContributionCalendar.THEMES[theme];
        }

        return ContributionCalendar.THEMES.github;
    }

    /**
     * Initialize the calendar
     */
    init() {
        // Clear any existing content
        this.container.innerHTML = '';

        // Create the calendar structure
        this.createCalendar();
    }

    /**
     * Create the calendar grid
     */
    createCalendar() {
        // Create main wrapper
        const wrapper = document.createElement('div');
        wrapper.className = 'contribution-calendar';

        // Create calendar title
        const title = document.createElement('div');
        title.className = 'calendar-title';
        title.textContent = `Contributions in ${this.config.year}`;
        wrapper.appendChild(title);

        // Create the grid container
        const grid = document.createElement('div');
        grid.className = 'calendar-grid';

        // Generate calendar data (we'll implement this next)
        const weeks = this.generateWeeks();

        // Create month labels
        const monthLabels = this.createMonthLabels(weeks);
        grid.appendChild(monthLabels);

        // Create day labels
        const dayLabels = this.createDayLabels();
        grid.appendChild(dayLabels);

        // Create the contribution cells
        const cells = this.createCells(weeks);
        grid.appendChild(cells);

        wrapper.appendChild(grid);
        this.container.appendChild(wrapper);
    }

    /**
     * Generate weeks for the entire year
     */
    generateWeeks() {
        const year = this.config.year;
        const startDate = new Date(year, 0, 1);
        const endDate = new Date(year, 11, 31);

        // Find the Sunday before or on January 1st
        const firstDay = new Date(startDate);
        firstDay.setDate(startDate.getDate() - startDate.getDay());

        const weeks = [];
        let currentDate = new Date(firstDay);

        while (currentDate <= endDate || weeks.length === 0) {
            const week = [];

            for (let day = 0; day < 7; day++) {
                const date = new Date(currentDate);
                const dateStr = this.formatDate(date);

                // Check if this date is in our data
                const contribution = this.config.data.find(d => d.date === dateStr);

                week.push({
                    date: date,
                    dateStr: dateStr,
                    count: contribution ? contribution.count : 0,
                    total: contribution?.total || null,
                    isCurrentYear: date.getFullYear() === year
                });

                currentDate.setDate(currentDate.getDate() + 1);
            }

            weeks.push(week);

            // Stop if we've passed the end of the year
            if (currentDate > endDate && currentDate.getMonth() === 0) {
                break;
            }
        }

        return weeks;
    }

    /**
     * Format date as YYYY-MM-DD
     */
    formatDate(date) {
        const year = date.getFullYear();
        const month = String(date.getMonth() + 1).padStart(2, '0');
        const day = String(date.getDate()).padStart(2, '0');
        return `${year}-${month}-${day}`;
    }

    /**
     * Create month labels
     */
    createMonthLabels(weeks) {
        const monthContainer = document.createElement('div');
        monthContainer.className = 'month-labels';

        const months = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun',
            'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];

        let lastMonth = -1;

        weeks.forEach((week, weekIndex) => {
            // Find the first day in the week that is in the current year
            const firstCurrentYearDay = week.find(day => day.isCurrentYear);

            if (firstCurrentYearDay) {
                const currentMonth = firstCurrentYearDay.date.getMonth();

                // Only show month label if it's a new month
                if (currentMonth !== lastMonth) {
                    const monthLabel = document.createElement('span');
                    monthLabel.className = 'month-label';
                    monthLabel.textContent = months[currentMonth];

                    // Calculate position: each week is cellSize + gap
                    const leftPosition = weekIndex * (this.config.cellSize + this.config.cellGap);
                    monthLabel.style.left = leftPosition + 'px';

                    monthContainer.appendChild(monthLabel);
                    lastMonth = currentMonth;
                }
            }
        });

        return monthContainer;
    }

    /**
     * Create day labels (Mon, Wed, Fri)
     */
    createDayLabels() {
        const dayContainer = document.createElement('div');
        dayContainer.className = 'day-labels';

        const days = ['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'];
        const displayDays = [1, 3, 5]; // Only show Mon, Wed, Fri

        days.forEach((day, index) => {
            const dayLabel = document.createElement('span');
            dayLabel.className = 'day-label';

            if (displayDays.includes(index)) {
                dayLabel.textContent = day;
            }

            dayContainer.appendChild(dayLabel);
        });

        return dayContainer;
    }

    /**
     * Create contribution cells
     */
    createCells(weeks) {
        const cellsContainer = document.createElement('div');
        cellsContainer.className = 'calendar-cells';

        weeks.forEach(week => {
            const weekColumn = document.createElement('div');
            weekColumn.className = 'week-column';

            week.forEach(day => {
                const cell = document.createElement('div');
                cell.className = 'calendar-cell';

                // Only show cells for the current year
                if (day.isCurrentYear) {
                    const level = this.getContributionLevel(day.count);
                    cell.style.backgroundColor = this.getColor(level);
                    cell.setAttribute('data-date', day.dateStr);
                    cell.setAttribute('data-count', day.count);
                    cell.setAttribute('data-level', level);

                    // Add interactivity
                    this.addCellEvents(cell, day);
                } else {
                    cell.classList.add('empty');
                }

                weekColumn.appendChild(cell);
            });

            cellsContainer.appendChild(weekColumn);
        });

        return cellsContainer;
    }

    /**
     * Get contribution level (0-4)
     */
    getContributionLevel(count) {
        if (count === 0) return 0;
        if (count <= 3) return 1;
        if (count <= 6) return 2;
        if (count <= 9) return 3;
        return 4;
    }

    /**
     * Get color for contribution level
     */
    getColor(level) {
        if (level === 0) return this.config.colors.empty;
        return this.config.colors.levels[level - 1];
    }

    /**
     * Add events to cell (hover, click)
     */
    addCellEvents(cell, day) {
        // Hover effect
        cell.addEventListener('mouseenter', (e) => {
            cell.classList.add('hovered');

            if (this.config.showTooltip) {
                this.showTooltip(e, day);
            }
        });

        cell.addEventListener('mouseleave', () => {
            cell.classList.remove('hovered');
            this.hideTooltip();
        });

        // Click event
        if (this.config.onClick) {
            cell.addEventListener('click', () => {
                this.config.onClick(day);
            });
            cell.style.cursor = 'pointer';
        }
    }

    /**
     * Show tooltip
     */
    showTooltip(event, day) {
        // Remove existing tooltip
        this.hideTooltip();

        const tooltip = document.createElement('div');
        tooltip.className = 'calendar-tooltip';

        const dateStr = day.date.toLocaleDateString('en-US', {
            year: 'numeric',
            month: 'long',
            day: 'numeric'
        });

        // Build tooltip content based on available data
        let content = `<strong>${day.count} ${this.config.labels.count}</strong>`;

        // Add total if available
        if (day.total !== null && day.total !== undefined) {
            const formattedTotal = typeof day.total === 'number'
                ? day.total.toLocaleString('en-US', { minimumFractionDigits: 2, maximumFractionDigits: 2 })
                : day.total;
            content += `<div class="tooltip-total">${this.config.labels.currency}${formattedTotal} ${this.config.labels.total}</div>`;
        }

        content += `<div class="tooltip-date">${dateStr}</div>`;

        tooltip.innerHTML = content;

        document.body.appendChild(tooltip);

        // Position tooltip
        const cellRect = event.target.getBoundingClientRect();
        tooltip.style.left = cellRect.left + (cellRect.width / 2) - (tooltip.offsetWidth / 2) + 'px';
        tooltip.style.top = cellRect.top - tooltip.offsetHeight - 10 + window.scrollY + 'px';

        this.currentTooltip = tooltip;
    }

    /**
     * Hide tooltip
     */
    hideTooltip() {
        if (this.currentTooltip) {
            this.currentTooltip.remove();
            this.currentTooltip = null;
        }
    }

    /**
     * Update calendar data
     */
    updateData(newData) {
        this.config.data = newData;
        this.init();
    }

    /**
     * Load data from external source
     * Supports various data formats and normalizes them
     */
    async loadData(source) {
        try {
            let data;

            // If source is a URL, fetch it
            if (typeof source === 'string') {
                const response = await fetch(source);
                data = await response.json();
            }
            // If source is a function, call it
            else if (typeof source === 'function') {
                data = await source();
            }
            // Otherwise assume it's raw data
            else {
                data = source;
            }

            // Normalize data format
            const normalizedData = this.normalizeData(data);
            this.updateData(normalizedData);

            return normalizedData;
        } catch (error) {
            console.error('Error loading calendar data:', error);
            throw error;
        }
    }

    /**
     * Normalize data to standard format
     * Accepts: [{date, count, total?}] or [{date, value}] or [{date, count, amount}]
     */
    normalizeData(data) {
        if (!Array.isArray(data)) {
            console.error('Data must be an array');
            return [];
        }

        return data.map(item => {
            // Handle different field names
            const normalized = {
                date: item.date || item.day || item.timestamp,
                count: item.count || item.value || item.quantity || 0
            };

            // Handle total field with various possible names
            if (item.total !== undefined) {
                normalized.total = item.total;
            } else if (item.amount !== undefined) {
                normalized.total = item.amount;
            } else if (item.sales !== undefined) {
                normalized.total = item.sales;
            } else if (item.revenue !== undefined) {
                normalized.total = item.revenue;
            }

            // Ensure date is in YYYY-MM-DD format
            if (normalized.date instanceof Date) {
                normalized.date = this.formatDate(normalized.date);
            } else if (typeof normalized.date === 'string') {
                // Try to parse and reformat if needed
                const parsedDate = new Date(normalized.date);
                if (!isNaN(parsedDate.getTime())) {
                    normalized.date = this.formatDate(parsedDate);
                }
            }

            return normalized;
        });
    }

    /**
     * Change theme
     */
    setTheme(themeName) {
        if (ContributionCalendar.THEMES[themeName]) {
            this.config.theme = themeName;
            this.config.colors = ContributionCalendar.THEMES[themeName];
            this.init();
        } else {
            console.warn(`Theme "${themeName}" not found`);
        }
    }

    /**
     * Set custom colors
     */
    setColors(colors) {
        this.config.colors = colors;
        this.init();
    }

    /**
     * Get available themes
     */
    static getAvailableThemes() {
        return Object.keys(ContributionCalendar.THEMES).map(key => ({
            key: key,
            name: ContributionCalendar.THEMES[key].name
        }));
    }

    /**
     * Destroy the calendar
     */
    destroy() {
        this.hideTooltip();
        this.container.innerHTML = '';
    }
}

// Export for use in other files
if (typeof module !== 'undefined' && module.exports) {
    module.exports = ContributionCalendar;
}
