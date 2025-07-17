<!-- filepath: App/Views/partials/calendar.php -->
<div
    x-data="calendar({ events: $wire?.calendarEvents || window.calendarEvents || [] })"
    x-init="init()"
    class="bg-white rounded-lg shadow p-4 w-full max-w-md mx-auto">
    <div class="flex items-center justify-between mb-2">
        <button @click="prevMonth" class="px-2 py-1 rounded hover:bg-gray-200">&lt;</button>
        <div class="font-semibold text-lg" x-text="monthNames[month] + ' ' + year"></div>
        <button @click="nextMonth" class="px-2 py-1 rounded hover:bg-gray-200">&gt;</button>
    </div>
    <div class="grid grid-cols-7 text-xs text-center text-gray-500 mb-1">
        <template x-for="day in dayNames" :key="day">
            <div x-text="day"></div>
        </template>
    </div>
    <template x-for="week in weeks" :key="week[0]">
        <div class="grid grid-cols-7 text-center min-h-[2rem]">
            <template x-for="d in week" :key="d ? d : 'blank'">
                <div class="py-1.5 relative">
                    <template x-if="d">
                        <div
                            class="w-8 h-8 mx-auto flex items-center justify-center rounded-full cursor-pointer"
                            :class="{
                                'bg-blue-500 text-white font-bold': isToday(d),
                                'bg-blue-100 text-blue-700': hasEvent(d) && !isToday(d),
                                'hover:bg-blue-50': !isToday(d) && !hasEvent(d)
                            }"
                            x-text="d"></div>
                    </template>
                    <template x-if="!d">
                        <div></div>
                    </template>
                    <!-- Event dot -->
                    <template x-if="d && hasEvent(d)">
                        <span class="absolute left-1/2 -translate-x-1/2 bottom-1 w-2 h-2 bg-blue-500 rounded-full"></span>
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