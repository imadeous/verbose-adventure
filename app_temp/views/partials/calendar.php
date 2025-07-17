<div
    x-data="calendar({ events: window.calendarEventsFromPHP || [] })"
    x-init="init()"
    class="bg-white rounded-lg shadow p-4 w-full max-w-md mx-auto">
    <div class="flex items-center justify-between mb-2">
        <button @click="prevMonth" class="px-2 py-1 rounded hover:bg-gray-200">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-6 w-6 text-gray-600">
                <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5 8.25 12l7.5-7.5" />
            </svg>
        </button>
        <div class="font-semibold text-lg" x-text="monthNames[month] + ' ' + year"></div>
        <button @click="nextMonth" class="px-2 py-1 rounded hover:bg-gray-200">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-6 w-6 text-gray-600">
                <path stroke-linecap="round" stroke-linejoin="round" d="m8.25 4.5 7.5 7.5-7.5 7.5" />
            </svg>

        </button>
    </div>
    <div class="grid grid-cols-7 text-xs text-center text-gray-500 mb-1">
        <template x-for="day in dayNames" :key="day">
            <div x-text="day"></div>
        </template>
    </div>
    <template x-for="(week, weekIdx) in weeks" :key="weekIdx">
        <div class="grid grid-cols-7 text-center min-h-[2rem]">
            <template x-for="(d, dayIdx) in week" :key="`${weekIdx}-${dayIdx}`">
                <div class="py-1.5 relative">
                    <template x-if="d !== null">
                        <div
                            class="w-8 h-8 mx-auto flex items-center justify-center rounded-full cursor-pointer"
                            :class="{
                                'bg-green-500 text-white font-bold': isToday(d),
                                'bg-green-100 text-green-700': hasEvent(d) && !isToday(d),
                                'hover:bg-green-50': !isToday(d) && !hasEvent(d)
                            }"
                            x-text="d"></div>
                    </template>
                    <template x-if="d === null">
                        <div></div>
                    </template>
                    <!-- Event dot -->
                    <template x-if="d !== null && hasEvent(d)">
                        <span class="absolute left-1/2 -translate-x-1/2 bottom-1 w-2 h-2 bg-yellow-500 rounded-full"></span>
                    </template>
                </div>
            </template>
        </div>
    </template>
</div>

<script>
    function calendar(config = {}) {
        return {
            month: (new Date()).getMonth(),
            year: (new Date()).getFullYear(),
            dayNames: ['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'],
            monthNames: [
                'January', 'February', 'March', 'April', 'May', 'June',
                'July', 'August', 'September', 'October', 'November', 'December'
            ],
            events: config.events || [],
            weeks: [],
            init() {
                if (window.calendarEventsFromPHP) {
                    this.events = window.calendarEventsFromPHP;
                }
                this.calculate();
            },
            calculate() {
                const firstDay = new Date(this.year, this.month, 1).getDay();
                const numDays = new Date(this.year, this.month + 1, 0).getDate();
                let days = [];
                // Fill blanks for first week
                for (let i = 0; i < firstDay; i++) days.push(null);
                // Fill days of month
                for (let d = 1; d <= numDays; d++) days.push(d);
                // Fill trailing blanks to complete last week
                while (days.length % 7 !== 0) days.push(null);
                // Split into weeks
                this.weeks = [];
                for (let i = 0; i < days.length; i += 7) {
                    this.weeks.push(days.slice(i, i + 7));
                }
            },
            weekIndex(week) {
                // Helper for unique key
                return week.map(d => d === null ? 'b' : d).join('-');
            },
            prevMonth() {
                if (this.month === 0) {
                    this.month = 11;
                    this.year--;
                } else {
                    this.month--;
                }
                this.calculate();
            },
            nextMonth() {
                if (this.month === 11) {
                    this.month = 0;
                    this.year++;
                } else {
                    this.month++;
                }
                this.calculate();
            },
            isToday(day) {
                const today = new Date();
                return (
                    day === today.getDate() &&
                    this.month === today.getMonth() &&
                    this.year === today.getFullYear()
                );
            },
            hasEvent(day) {
                const m = this.month + 1;
                const d = day;
                const y = this.year;
                return this.events.some(ev => {
                    if (!ev.date) return false;
                    const [evYear, evMonth, evDay] = ev.date.split('-').map(Number);
                    return evYear === y && evMonth === m && evDay === d;
                });
            }
        }
    }
    <?php if (isset($calendarEvents)): ?>
        window.calendarEventsFromPHP = <?= json_encode($calendarEvents) ?>;
    <?php endif; ?>
</script>