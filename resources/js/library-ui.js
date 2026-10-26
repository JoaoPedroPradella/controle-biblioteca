import { createApp, onBeforeUnmount, onMounted, ref, watch } from 'vue';

const libraryUi = document.querySelector('#library-vue-ui');

if (libraryUi) {
    createApp({
        setup() {
            const sidebarOpen = ref(false);
            const profileOpen = ref(false);
            const sidebar = document.querySelector('[data-sidebar]');
            const sidebarToggle = document.querySelector('[data-sidebar-toggle]');
            const sidebarBackdrop = document.querySelector('[data-sidebar-backdrop]');
            const profileToggle = document.querySelector('[data-profile-toggle]');
            const profileMenu = document.querySelector('[data-profile-menu]');
            const autoSubmitFields = document.querySelectorAll('[data-auto-submit]');

            const syncSidebar = (isOpen) => {
                sidebar?.classList.toggle('is-open', isOpen);
                sidebarBackdrop?.toggleAttribute('hidden', !isOpen);
                sidebarToggle?.setAttribute('aria-expanded', String(isOpen));
            };

            const syncProfile = (isOpen) => {
                profileMenu?.classList.toggle('is-visible', isOpen);
                profileToggle?.setAttribute('aria-expanded', String(isOpen));
            };

            const closeSidebar = () => {
                sidebarOpen.value = false;
            };

            const closeProfile = () => {
                profileOpen.value = false;
            };

            const toggleSidebar = () => {
                sidebarOpen.value = !sidebarOpen.value;
                closeProfile();
            };

            const toggleProfile = () => {
                profileOpen.value = !profileOpen.value;
            };

            const submitFilters = (event) => {
                event.currentTarget.form?.requestSubmit();
            };

            const handleKeydown = (event) => {
                if (event.key === 'Escape') {
                    closeSidebar();
                    closeProfile();
                }
            };

            onMounted(() => {
                sidebarToggle?.addEventListener('click', toggleSidebar);
                sidebarBackdrop?.addEventListener('click', closeSidebar);
                profileToggle?.addEventListener('click', toggleProfile);
                autoSubmitFields.forEach((field) => field.addEventListener('change', submitFilters));
                document.addEventListener('keydown', handleKeydown);
            });

            onBeforeUnmount(() => {
                sidebarToggle?.removeEventListener('click', toggleSidebar);
                sidebarBackdrop?.removeEventListener('click', closeSidebar);
                profileToggle?.removeEventListener('click', toggleProfile);
                autoSubmitFields.forEach((field) => field.removeEventListener('change', submitFilters));
                document.removeEventListener('keydown', handleKeydown);
            });

            watch(sidebarOpen, syncSidebar, { immediate: true });
            watch(profileOpen, syncProfile, { immediate: true });

            return () => null;
        },
    }).mount(libraryUi);
}
