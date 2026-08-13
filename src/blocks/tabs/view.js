document.addEventListener('DOMContentLoaded', () => {
    const nxTabs = document.querySelectorAll('.wp-block-hang-tabs');

    nxTabs.forEach(nxTab => {
        const navItems = nxTab.querySelectorAll('.tabs-nav .nav-item');
        const tabItems = nxTab.querySelectorAll('.tabs-content .tab-item');

        navItems.forEach(nav => {
            nav.addEventListener('click', () => {
                const targetId = nav.getAttribute('data-nav');

                // Nav Active Class
                navItems.forEach(i => i.classList.remove('active'));
                nav.classList.add('active');

                // Tab Content Show/Hide
                tabItems.forEach(tab => {
                    if (tab.getAttribute('data-tab') === targetId) {
                        tab.classList.add('show');
                        tab.setAttribute('aria-hidden', 'false');
                    } else {
                        tab.classList.remove('show');
                        tab.setAttribute('aria-hidden', 'true');
                    }
                });
            });
        });
    });
});
