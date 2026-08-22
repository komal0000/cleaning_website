  @foreach ($careers as $career)
      <div
          class="bg-white p-8 rounded-lg shadow-lg border-t-4 border-blue-500 hover:shadow-xl transition-shadow h-full flex flex-col">
          <div class="flex items-center mb-4">
              <div class="bg-blue-100 p-3 rounded-lg mr-4">
                  <span class="text-2xl">🏢</span>
              </div>
              <div>
                  <h2 class="text-xl font-semibold text-blue-700">
                      {{ $career->title }}
                  </h2>
                  <p class="text-blue-600 font-medium">📍 {{ $career->location }}</p>
              </div>
          </div>
          <div class="h-1 w-20 bg-blue-500 mb-4"></div>
          <div class="flex-grow">
              <p class="text-gray-700 mb-4 leading-relaxed text-sm">
                  {{ $career->description }}
              </p>
              <div class="mb-4">
                  <h4 class="font-semibold text-gray-800 mb-2">Key Requirements:</h4>
                  <ul class="text-sm text-gray-600 space-y-1">
                      @foreach (explode('|', $career->requirement) as $req)
                          <li>• {{ $req }}</li>
                      @endforeach
                  </ul>
              </div>
          </div>
          <a href="#apply" onclick="scrollToApply(event)"
              class="inline-flex items-center justify-center bg-blue-600 hover:bg-blue-700 text-white font-medium py-3 px-6 rounded-md transition-colors mt-4">
              <span class="mr-2">👉</span> Apply Now
          </a>
      </div>
  @endforeach
