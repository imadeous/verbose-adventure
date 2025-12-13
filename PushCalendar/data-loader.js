/**
 * Data Loader Utilities for Contribution Calendar
 * Helpers for loading data from various sources
 */

class CalendarDataLoader {
    /**
     * Load data from a JSON file
     */
    static async fromJSON(url) {
        try {
            const response = await fetch(url);
            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }
            return await response.json();
        } catch (error) {
            console.error('Error loading JSON:', error);
            throw error;
        }
    }

    /**
     * Load data from CSV (simulated)
     * In real scenario, you'd parse CSV properly
     */
    static async fromCSV(url) {
        try {
            const response = await fetch(url);
            const text = await response.text();
            return this.parseCSV(text);
        } catch (error) {
            console.error('Error loading CSV:', error);
            throw error;
        }
    }

    /**
     * Parse CSV text to data array
     */
    static parseCSV(csvText) {
        const lines = csvText.trim().split('\n');
        const headers = lines[0].split(',').map(h => h.trim());
        const data = [];

        for (let i = 1; i < lines.length; i++) {
            const values = lines[i].split(',').map(v => v.trim());
            const row = {};

            headers.forEach((header, index) => {
                const value = values[index];
                // Try to parse numbers
                row[header] = isNaN(value) ? value : parseFloat(value);
            });

            data.push(row);
        }

        return data;
    }

    /**
     * Simulate database query (for demo purposes)
     * In real scenario, this would make an API call to your backend
     */
    static async fromDatabase(query) {
        console.log('Simulating database query:', query);

        // Simulate network delay
        await new Promise(resolve => setTimeout(resolve, 500));

        // Return mock data based on query type
        if (query.type === 'sales') {
            return this.generateMockSalesData(query.year);
        } else {
            return this.generateMockContributionData(query.year);
        }
    }

    /**
     * Generate mock sales data with totals
     */
    static generateMockSalesData(year = 2025) {
        const data = [];

        for (let month = 0; month < 12; month++) {
            const daysInMonth = new Date(year, month + 1, 0).getDate();

            for (let day = 1; day <= daysInMonth; day++) {
                // Simulate varying sales patterns
                if (Math.random() > 0.2) {
                    const dateStr = `${year}-${String(month + 1).padStart(2, '0')}-${String(day).padStart(2, '0')}`;
                    const orderCount = Math.floor(Math.random() * 50) + 1;
                    const avgOrderValue = 25 + Math.random() * 100;
                    const salesTotal = orderCount * avgOrderValue;

                    data.push({
                        date: dateStr,
                        count: orderCount,
                        total: Math.round(salesTotal * 100) / 100
                    });
                }
            }
        }

        return data;
    }

    /**
     * Generate mock contribution data (no totals)
     */
    static generateMockContributionData(year = 2025) {
        const data = [];

        for (let month = 0; month < 12; month++) {
            const daysInMonth = new Date(year, month + 1, 0).getDate();

            for (let day = 1; day <= daysInMonth; day++) {
                if (Math.random() > 0.3) {
                    const dateStr = `${year}-${String(month + 1).padStart(2, '0')}-${String(day).padStart(2, '0')}`;
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

    /**
     * Load from localStorage
     */
    static fromLocalStorage(key) {
        try {
            const stored = localStorage.getItem(key);
            return stored ? JSON.parse(stored) : [];
        } catch (error) {
            console.error('Error loading from localStorage:', error);
            return [];
        }
    }

    /**
     * Save to localStorage
     */
    static toLocalStorage(key, data) {
        try {
            localStorage.setItem(key, JSON.stringify(data));
            return true;
        } catch (error) {
            console.error('Error saving to localStorage:', error);
            return false;
        }
    }

    /**
     * Transform data for specific use cases
     */
    static transform(data, transformer) {
        if (typeof transformer === 'function') {
            return data.map(transformer);
        }
        return data;
    }

    /**
     * Filter data by date range
     */
    static filterByDateRange(data, startDate, endDate) {
        const start = new Date(startDate);
        const end = new Date(endDate);

        return data.filter(item => {
            const date = new Date(item.date);
            return date >= start && date <= end;
        });
    }

    /**
     * Aggregate data by period (day, week, month)
     */
    static aggregateBy(data, period = 'day') {
        const aggregated = {};

        data.forEach(item => {
            let key;
            const date = new Date(item.date);

            switch (period) {
                case 'week':
                    // Get Monday of the week
                    const monday = new Date(date);
                    monday.setDate(date.getDate() - date.getDay() + 1);
                    key = monday.toISOString().split('T')[0];
                    break;
                case 'month':
                    key = `${date.getFullYear()}-${String(date.getMonth() + 1).padStart(2, '0')}-01`;
                    break;
                default:
                    key = item.date;
            }

            if (!aggregated[key]) {
                aggregated[key] = { date: key, count: 0, total: 0 };
            }

            aggregated[key].count += item.count || 0;
            aggregated[key].total += item.total || 0;
        });

        return Object.values(aggregated);
    }

    /**
     * Validate data format
     */
    static validate(data) {
        const errors = [];

        if (!Array.isArray(data)) {
            errors.push('Data must be an array');
            return { valid: false, errors };
        }

        data.forEach((item, index) => {
            if (!item.date) {
                errors.push(`Item at index ${index} missing required field: date`);
            }
            if (item.count === undefined && item.value === undefined) {
                errors.push(`Item at index ${index} missing count or value field`);
            }
        });

        return {
            valid: errors.length === 0,
            errors
        };
    }
}

// Export for use in other files
if (typeof module !== 'undefined' && module.exports) {
    module.exports = CalendarDataLoader;
}
