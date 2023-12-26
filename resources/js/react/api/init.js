import axios from 'axios'

export const instance = axios.create({
    headers: {
        'Access-Control-Allow-Origin': '*',
        'Access-Control-Allow-Methods': 'POST',
        'Access-Control-Allow-Headers': 'X-CSRF-Token',
        'Content-Type': 'application/json',
    },
    baseURL: 'http://localhost:8000/api',
    timeout: 50000,
})
