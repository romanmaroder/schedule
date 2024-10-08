let prefers = window.matchMedia('(prefers-color-scheme: dark)').matches ? 'dark' : 'light';
let html = document.querySelector('html');
let body = document.querySelector('body');

html.classList.add(prefers);
html.setAttribute('data-bs-theme', prefers);

