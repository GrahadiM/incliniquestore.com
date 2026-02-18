
<!-- Footer -->
<footer class="bg-gray-800 text-white py-8 lg:pb-12 pb-24">
    <div class="w-full lg:max-w-7xl mx-auto px-4">
        <div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-4 text-md gap-8">
            <div class="col-span-1 md:col-span-3 lg:col-span-1">
                <h3 class="text-2xl font-bold mb-4">Inclinique<span class="text-primary-orange"> Store</span></h3>
                <p class="text-md text-justify text-gray-300 mb-4">
                    Rangkaian skincare terbaik dengan formula yang aman dan efektif untuk semua jenis kulit.
                </p>
                <div class="flex">
                    <a href="#" class="text-2xl text-gray-300 hover:text-white px-2"><i class="fab fa-instagram"></i></a>
                    <a href="#" class="text-2xl text-gray-300 hover:text-white px-2"><i class="fab fa-facebook"></i></a>
                    <a href="#" class="text-2xl text-gray-300 hover:text-white px-2"><i class="fab fa-tiktok"></i></a>
                    <a href="#" class="text-2xl text-gray-300 hover:text-white px-2"><i class="fab fa-twitter"></i></a>
                </div>
            </div>

            <div>
                <h4 class="uppercase font-semibold border-b-2 pb-4 border-gray-600 mb-4">Quick Links</h4>
                <ul class="space-y-2">
                    <li><a href="{{ route('frontend.index') }}" class="text-gray-300 hover:text-white">About Us</a></li>
                    <li><a href="{{ route('frontend.shop.index') }}" class="text-gray-300 hover:text-white">Shop All</a></li>
                    <li><a href="{{ route('frontend.blog.index') }}" class="text-gray-300 hover:text-white">Beauty Article</a></li>
                    <li><a href="{{ route('frontend.index') }}/#store_locations" class="text-gray-300 hover:text-white">Offline Store</a></li>
                    <li><a href="{{ route('frontend.index') }}" class="text-gray-300 hover:text-white">Order Tracking</a></li>
                </ul>
            </div>

            <div>
                <h4 class="uppercase font-semibold border-b-2 pb-4 border-gray-600 mb-4">Services</h4>
                <ul class="space-y-2">
                    <li><a href="{{ route('frontend.index') }}" class="text-gray-300 hover:text-white">FAQ</a></li>
                    <li><a href="{{ route('frontend.index') }}" class="text-gray-300 hover:text-white">Terms & Conditions</a></li>
                    <li><a href="{{ route('frontend.index') }}" class="text-gray-300 hover:text-white">Privacy Policy</a></li>
                    <li><a href="{{ route('frontend.index') }}" class="text-gray-300 hover:text-white">Membership</a></li>
                    <li><a href="{{ route('frontend.index') }}" class="text-gray-300 hover:text-white">Sitemap</a></li>
                </ul>
            </div>

            <div>
                <h4 class="uppercase font-semibold border-b-2 pb-4 border-gray-600 mb-4">Contact Us</h4>
                <ul class="space-y-2 text-gray-300">
                    <li class="flex items-center">
                        <i class="fas fa-phone mr-3"></i>
                        <span>+62 857 6711 3554</span>
                    </li>
                    <li class="flex items-center">
                        <i class="fas fa-envelope mr-3"></i>
                        <span>admin@incliniquestore.com</span>
                    </li>
                    <li class="flex items-center">
                        <i class="fas fa-map-location-dot mr-3"></i>
                        <span>Jl. Skincare No. 123, Jakarta</span>
                    </li>
                </ul>
            </div>
        </div>

        <div class="border-t border-gray-700 mt-8 pt-8 text-center text-gray-300">
            <p>&copy; 2025 Inclinique Store. All rights reserved.
            </p>
        </div>
    </div>
</footer>
