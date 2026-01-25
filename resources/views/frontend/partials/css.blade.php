<style>
    .scrollbar-hide {
        -ms-overflow-style: none; /* IE & Edge */
        scrollbar-width: none; /* Firefox */
    }

    .scrollbar-hide::-webkit-scrollbar {
        display: none; /* Chrome, Safari */
    }

    .hero-section {
        background: linear-gradient(135deg, #FFECC0 0%, #FA812F 100%);
        /* background: #FFECC0; */
    }

    .skin-type-btn.active {
        background-color: #FA812F;
        color: white;
    }

    /* Sidebar Styles */
    .sidebar {
        transform: translateX(-100%);
        transition: transform 0.3s ease-in-out;
    }

    .sidebar.open {
        transform: translateX(0);
    }

    .sidebar-overlay {
        opacity: 0;
        visibility: hidden;
        transition: opacity 0.3s ease-in-out, visibility 0.3s ease-in-out;
    }

    .sidebar-overlay.open {
        opacity: 1;
        visibility: visible;
    }

    /* Search Popup Styles */
    .search-popup {
        transform: translateY(-100%);
        opacity: 0;
        transition: transform 0.3s ease-in-out, opacity 0.3s ease-in-out;
    }

    .search-popup.open {
        transform: translateY(0);
        opacity: 1;
    }

    .search-overlay {
        opacity: 0;
        visibility: hidden;
        transition: opacity 0.3s ease-in-out, visibility 0.3s ease-in-out;
    }

    .search-overlay.open {
        opacity: 1;
        visibility: visible;
    }

    /* Bottom Navigation */
    .bottom-nav {
        box-shadow: 0 -2px 10px rgba(0, 0, 0, 0.1);
    }

    /* Custom colors */
    .bg-primary-light {
        background-color: #FFECC0;
    }

    .bg-primary-yellow {
        background-color: #FAB12F;
    }

    .bg-primary-orange {
        background-color: #FA812F;
    }

    .bg-primary-red {
        background-color: #DD0303;
    }

    .bg-primary-green {
        background-color: #28A745;
    }

    .bg-primary-blue {
        background-color: #007BFF;
    }

    .bg-primary-purple {
        background-color: #6F42C1;
    }

    .bg-primary-pink {
        background-color: #E83E8C;
    }

    .bg-primary-indigo {
        background-color: #6610F2;
    }

    .bg-primary-teal {
        background-color: #20C997;
    }

    .bg-primary-cyan {
        background-color: #17A2B8;
    }

    .text-primary-light {
        color: #FFECC0;
    }

    .text-outline-primary-light {
        -webkit-text-stroke: 1px #FFECC0;
        color: transparent;
    }

    .text-primary-dark {
        color: #343A40;
    }

    .text-outline-primary-dark {
        -webkit-text-stroke: 1px #343A40;
        color: transparent;
    }

    .text-primary-yellow {
        color: #FAB12F;
    }

    .text-outline-primary-yellow {
        -webkit-text-stroke: 1px #FAB12F;
        color: transparent;
    }

    .text-primary-orange {
        color: #FA812F;
    }

    .text-outline-primary-orange {
        -webkit-text-stroke: 1px #FA812F;
        color: transparent;
    }

    .text-primary-red {
        color: #DD0303;
    }

    .text-outline-primary-red {
        -webkit-text-stroke: 1px #DD0303;
        color: transparent;
    }

    .text-primary-green {
        color: #28A745;
    }

    .text-outline-primary-green {
        -webkit-text-stroke: 1px #28A745;
        color: transparent;
    }

    .text-primary-blue {
        color: #007BFF;
    }

    .text-outline-primary-blue {
        -webkit-text-stroke: 1px #007BFF;
        color: transparent;
    }

    .border-primary-orange {
        border-color: #FA812F;
    }

    .border-outline-primary-orange {
        border-color: transparent;
        -webkit-text-stroke: 1px #FA812F;
    }

    .hover\:bg-primary-orange:hover {
        background-color: #FA812F;
    }

    .hover\:text-primary-orange:hover {
        color: #FA812F;
    }

    /* Custom button styles */
    .btn-block {
        display: block;
        width: 100%;
        text-align: center;
    }
</style>
