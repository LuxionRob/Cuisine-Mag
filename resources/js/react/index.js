import React from 'react'
import ReactDOM from 'react-dom/client'
import { MapDetermination } from './components'

if (document.getElementById('map-determination')) {
    console.log('Get')
    const root = ReactDOM.createRoot(document.getElementById('map-determination'))
    root.render(<MapDetermination />)
}
