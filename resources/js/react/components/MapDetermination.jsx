import { useState, useEffect } from 'react'
import { MapContainer, TileLayer, Popup, useMap } from 'react-leaflet'
import 'leaflet-defaulticon-compatibility'
import 'leaflet-defaulticon-compatibility/dist/leaflet-defaulticon-compatibility.webpack.css'
import { SearchBar, CustomMarker, UserLocationMarker } from './index'

export default function MapDetermination({ provider, marker }) {
    const position = [10, 106]
    const [isShowUserLocation, setIsShowUserLocation] = useState(false)

    const handleUserLocation = e => {
        e.preventDefault()
        setIsShowUserLocation(!isShowUserLocation)
    }
    return (
        <MapContainer center={position} zoom={17} scrollWheelZoom={true} className="h-96 w-full">
            <TileLayer
                attribution='&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
                url="https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png"
            />
            <SearchBar provider={provider} />
            {/* <button onClick={handleUserLocation}>O</button>
            {isShowUserLocation && <UserLocationMarker />} */}
            <CustomMarker marker={marker} />
        </MapContainer>
    )
}
