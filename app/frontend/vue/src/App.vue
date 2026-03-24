<template>
  <div>
    <h1>Переводчики</h1>

    <label>Выберите день недели:
      <select v-model="day" @change="load">
        <option v-for="(name, index) in dayNames" :key="index" :value="index + 1">
          {{ name }}
        </option>
      </select>
    </label>

    <div v-if="translators.length">
      <div v-for="t in translators" :key="t.id" class="card">
        <h3>{{ t.name }} ({{ t.language }})</h3>
        <p>Статус: <b>{{ t.is_busy ? 'Занят' : 'Свободен' }}</b></p>
        <p>Рабочие дни: {{ formatDays(t.schedules) }}</p>
      </div>
    </div>

    <p v-else>{{ message }}</p>
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue'

const translators = ref([])
const day = ref(1)
const message = ref('Загрузка...')
fetch('http://localhost:21080/backend/web/index.php?r=translator/available&day=1')
    .then(res => res.json())
    .then(data => console.log('SUCCESS:', data))
    .catch(err => console.error('ERROR:', err))

const dayNames = ['Пн','Вт','Ср','Чт','Пт','Сб','Вс']


const API = 'http://127.0.0.1:21080/backend/web/index.php?r='


function formatDays(schedules) {
  return schedules
      .filter(s => s.is_working)
      .map(s => dayNames[s.day_of_week - 1])
      .join(', ')
}

async function load() {
  try {
    const res = await fetch(API + `translator/available&day=${day.value}`)
    const json = await res.json()

    console.log('API RESPONSE:', json)

    if (json.status === 'ok' && json.data.length) {
      translators.value = json.data
      message.value = ''
    } else {
      translators.value = []
      message.value = json.message || 'Нет свободных переводчиков'
    }
  } catch (e) {
    console.error('Ошибка загрузки переводчиков:', e)
    translators.value = []
    message.value = 'Ошибка загрузки данных'
  }
}


onMounted(load)
</script>

<style>
.card {
  border: 1px solid #ccc;
  margin: 10px;
  padding: 10px;
  border-radius: 5px;
}
</style>