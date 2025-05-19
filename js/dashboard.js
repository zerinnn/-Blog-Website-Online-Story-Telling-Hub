
'use strict';
const sidebar = document.querySelector('aside');
const showSidebarBtn = document.getElementById('show_sidebar_btn');
const hideSidebarBtn = document.getElementById('hide_sidebar_btn');

const showSidebar = () => {
    sidebar.style.left = '0';
    showSidebarBtn.style.display = 'none';
    hideSidebarBtn.style.display = 'inline-block';
};

const hideSidebar = () => {
    sidebar.style.left = '-100%';
    showSidebarBtn.style.display = 'inline-block';
    hideSidebarBtn.style.display = 'none';
};

showSidebarBtn.addEventListener('click', showSidebar);
hideSidebarBtn.addEventListener('click', hideSidebar);
