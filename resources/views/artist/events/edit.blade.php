<!-- resources/views/artist/events/edit.blade.php -->

@extends('layout.app')

@section('content')
    <div class="container">
        <h1>Edit Event: {{ $event->title }}</h1>

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('artist.events.update', $event->id) }}" method="POST" enctype="multipart/form-data" id="eventForm">
            @csrf
            @method('PUT')

            <!-- Title -->
            <div class="mb-3">
                <label for="title" class="form-label">Event Title</label>
                <input type="text" class="form-control" id="title" name="title"
                    value="{{ old('title', $event->title) }}" required>
            </div>
            
            <!-- Image Upload -->
            <div class="mb-3">
                <label for="image" class="form-label">Event Image</label>
                <input type="file" class="form-control" id="image" name="image"
                    accept="image/jpeg,image/png,image/jpg,image/gif,image/svg+xml">
                @if ($event->image)
                    <img src="{{ asset('storage/' . $event->image) }}" alt="Event Image" class="mt-2" width="150">
                @endif
            </div>
            
            <!-- Location Search -->
            <div class="mb-3">
                <label for="location_search" class="form-label">Event Location</label>
                <div class="input-group">
                    <input type="text" class="form-control" id="location_search" name="location_search" 
                        placeholder="Enter venue name or address" 
                        value="{{ old('location_search', $event->location_address) }}" required>
                    <button class="btn btn-outline-secondary" type="button" id="useCurrentLocation">
                        <i class="bi bi-geo-alt"></i> Use Current
                    </button>
                </div>
                <div id="location_status" class="form-text text-muted">
                    @if($event->latitude && $event->longitude)
                        <span class="text-success">✓ Location saved ({{ $event->latitude }}, {{ $event->longitude }})</span>
                    @endif
                </div>
                <div id="location_suggestions" class="list-group mt-1" style="display: none;"></div>
            </div>

            <!-- Hidden Latitude & Longitude Fields -->
            <input type="hidden" id="latitude" name="latitude" value="{{ old('latitude', $event->latitude) }}">
            <input type="hidden" id="longitude" name="longitude" value="{{ old('longitude', $event->longitude) }}">

            <!-- Manual Location Input (Optional) -->
            <div class="mb-3">
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" id="manualLocation">
                    <label class="form-check-label" for="manualLocation">
                        Edit coordinates manually
                    </label>
                </div>
            </div>

            <div class="row" id="manualCoordinates" style="display: none;">
                <div class="col-md-6 mb-3">
                    <label for="manual_lat" class="form-label">Latitude</label>
                    <input type="text" class="form-control" id="manual_lat" 
                        value="{{ old('latitude', $event->latitude) }}" placeholder="e.g., 40.7128">
                </div>
                <div class="col-md-6 mb-3">
                    <label for="manual_lng" class="form-label">Longitude</label>
                    <input type="text" class="form-control" id="manual_lng" 
                        value="{{ old('longitude', $event->longitude) }}" placeholder="e.g., -74.0060">
                </div>
            </div>

            <!-- Event Date -->
            <div class="mb-3">
                <label for="event_date" class="form-label">Event Date & Time</label>
                <input type="datetime-local" class="form-control" id="event_date" name="event_date"
                    value="{{ old('event_date', $event->event_date->format('Y-m-d\TH:i')) }}" required>
            </div>

            <!-- Ticket Link -->
            <div class="mb-3">
                <label for="ticket_link" class="form-label">Ticket Purchase Link (optional)</label>
                <input type="url" class="form-control" id="ticket_link" name="ticket_link"
                    value="{{ old('ticket_link', $event->ticket_link) }}">
            </div>

            <!-- Promotional Details -->
            <div class="mb-3">
                <label for="promotional_details" class="form-label">Promotional Details</label>
                <textarea class="form-control" id="promotional_details" name="promotional_details" rows="3">{{ old('promotional_details', $event->promotional_details) }}</textarea>
            </div>

            <button type="submit" class="btn btn-primary">Update Event</button>
        </form>
    </div>

    <script>
        let searchTimeout;
        const locationInput = document.getElementById('location_search');
        const suggestionsDiv = document.getElementById('location_suggestions');
        const latitudeInput = document.getElementById('latitude');
        const longitudeInput = document.getElementById('longitude');
        const locationStatus = document.getElementById('location_status');
        const manualCheckbox = document.getElementById('manualLocation');
        const manualCoords = document.getElementById('manualCoordinates');
        const manualLat = document.getElementById('manual_lat');
        const manualLng = document.getElementById('manual_lng');
        const useCurrentBtn = document.getElementById('useCurrentLocation');

        // Search locations as user types
        locationInput.addEventListener('input', function() {
            const query = this.value;
            
            if (query.length < 3) {
                suggestionsDiv.style.display = 'none';
                return;
            }

            clearTimeout(searchTimeout);
            searchTimeout = setTimeout(() => searchLocations(query), 500);
        });

        // Search locations using Nominatim (OpenStreetMap)
        function searchLocations(query) {
            fetch(`https://nominatim.openstreetmap.org/search?format=json&q=${encodeURIComponent(query)}&limit=5`)
                .then(response => response.json())
                .then(data => {
                    if (data.length > 0) {
                        suggestionsDiv.innerHTML = '';
                        data.forEach(place => {
                            const item = document.createElement('a');
                            item.href = '#';
                            item.className = 'list-group-item list-group-item-action';
                            item.innerHTML = `
                                <div>
                                    <strong>${place.display_name.split(',')[0]}</strong><br>
                                    <small>${place.display_name}</small>
                                </div>
                            `;
                            item.addEventListener('click', (e) => {
                                e.preventDefault();
                                selectLocation(place);
                            });
                            suggestionsDiv.appendChild(item);
                        });
                        suggestionsDiv.style.display = 'block';
                    } else {
                        suggestionsDiv.style.display = 'none';
                    }
                })
                .catch(error => {
                    console.error('Error searching locations:', error);
                });
        }

        // Select location from suggestions
        function selectLocation(place) {
            locationInput.value = place.display_name;
            latitudeInput.value = place.lat;
            longitudeInput.value = place.lon;
            locationStatus.innerHTML = '<span class="text-success">✓ Location updated</span>';
            suggestionsDiv.style.display = 'none';
        }

        // Hide suggestions when clicking outside
        document.addEventListener('click', function(e) {
            if (!locationInput.contains(e.target) && !suggestionsDiv.contains(e.target)) {
                suggestionsDiv.style.display = 'none';
            }
        });

        // Use current location
        useCurrentBtn.addEventListener('click', function() {
            locationStatus.innerHTML = '<span class="text-info">Getting your location...</span>';
            
            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(
                    function(position) {
                        const lat = position.coords.latitude;
                        const lng = position.coords.longitude;
                        
                        // Reverse geocoding to get address
                        fetch(`https://nominatim.openstreetmap.org/reverse?format=json&lat=${lat}&lon=${lng}`)
                            .then(response => response.json())
                            .then(data => {
                                locationInput.value = data.display_name;
                                latitudeInput.value = lat;
                                longitudeInput.value = lng;
                                locationStatus.innerHTML = '<span class="text-success">✓ Current location set</span>';
                            })
                            .catch(() => {
                                locationInput.value = `${lat}, ${lng}`;
                                latitudeInput.value = lat;
                                longitudeInput.value = lng;
                                locationStatus.innerHTML = '<span class="text-success">✓ Current location coordinates set</span>';
                            });
                    },
                    function(error) {
                        let message = 'Error getting location: ';
                        switch(error.code) {
                            case error.PERMISSION_DENIED:
                                message += 'Permission denied';
                                break;
                            case error.POSITION_UNAVAILABLE:
                                message += 'Position unavailable';
                                break;
                            case error.TIMEOUT:
                                message += 'Timeout';
                                break;
                        }
                        locationStatus.innerHTML = `<span class="text-danger">${message}</span>`;
                    }
                );
            } else {
                locationStatus.innerHTML = '<span class="text-danger">Geolocation not supported</span>';
            }
        });

        // Manual coordinates toggle
        manualCheckbox.addEventListener('change', function() {
            if (this.checked) {
                manualCoords.style.display = 'flex';
                locationInput.disabled = true;
                useCurrentBtn.disabled = true;
                
                // Set manual fields with current values
                manualLat.value = latitudeInput.value;
                manualLng.value = longitudeInput.value;
            } else {
                manualCoords.style.display = 'none';
                locationInput.disabled = false;
                useCurrentBtn.disabled = false;
                
                // Update hidden fields with manual values if they exist
                if (manualLat.value && manualLng.value) {
                    latitudeInput.value = manualLat.value;
                    longitudeInput.value = manualLng.value;
                }
            }
        });

        // Manual coordinates input
        manualLat.addEventListener('input', updateManualCoords);
        manualLng.addEventListener('input', updateManualCoords);

        function updateManualCoords() {
            if (manualLat.value && manualLng.value) {
                latitudeInput.value = manualLat.value;
                longitudeInput.value = manualLng.value;
                locationStatus.innerHTML = '<span class="text-success">✓ Manual coordinates set</span>';
            }
        }

        // Form validation
        document.getElementById('eventForm').addEventListener('submit', function(e) {
            if (!manualCheckbox.checked) {
                const lat = latitudeInput.value;
                const lng = longitudeInput.value;
                
                if (!lat || !lng) {
                    e.preventDefault();
                    alert('Please select a valid location from suggestions or use current location.');
                }
            } else {
                const lat = manualLat.value;
                const lng = manualLng.value;
                
                if (!lat || !lng) {
                    e.preventDefault();
                    alert('Please enter both latitude and longitude coordinates.');
                } else if (isNaN(lat) || isNaN(lng) || lat < -90 || lat > 90 || lng < -180 || lng > 180) {
                    e.preventDefault();
                    alert('Please enter valid coordinates (Lat: -90 to 90, Lng: -180 to 180).');
                }
            }
        });

        // Add Bootstrap Icons for the location button
        const style = document.createElement('link');
        style.rel = 'stylesheet';
        style.href = 'https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.1/font/bootstrap-icons.css';
        document.head.appendChild(style);
    </script>
@endsection