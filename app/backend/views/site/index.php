<?php

/** @var yii\web\View $this */

$this->title = 'My Yii Application';
?>
<div id="app">
    <div v-for="t in translators" :key="t.id" style="margin-bottom:20px;">

        <h3>{{ t.name }} ({{ t.language }})</h3>

        <div>
            Статус:
            <b v-if="t.is_busy">Занят</b>
            <b v-else>Свободен</b>
        </div>

        <div>
            Рабочие дни:
            {{ formatDays(t.schedules) }}
        </div>

    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/vue@2"></script>

<script>
    new Vue({
        el: '#app',
        data: {
            translators: []
        },
        methods: {
            formatDays(schedules) {
                const map = {
                    1: 'Пн', 2: 'Вт', 3: 'Ср',
                    4: 'Чт', 5: 'Пт', 6: 'Сб', 7: 'Вс'
                };

                return schedules
                    .filter(s => s.is_working)
                    .map(s => map[s.day_of_week])
                    .join(', ');
            }
        },
        mounted() {
            fetch('/backend/web/index.php?r=translator/list')
                .then(res => res.json())
                .then(data => {
                    this.translators = data;
                });
        }
    });
</script>
