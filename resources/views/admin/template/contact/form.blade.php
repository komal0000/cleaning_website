<div>
    <label for="service" class="block text-sm font-medium text-gray-700 mb-2">
        Service Needed *
    </label>
    <select id="service" name="service" required
        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors">
        <option value="">Select a service</option>
        @foreach ($services as $service)
            <option value="{{ $service->title }}">{{ $service->title }}</option>
        @endforeach
        <option value="Career Opportunities">Career Opportunities</option>
        <option value="Other">Other</option>
    </select>
</div>
