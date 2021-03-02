function render() {
    const js = document.getElementById('ipg');
    const el = document.createElement('iframe');
    el.setAttribute('src', 'http://dev.local/devs/3rd-party-cookies/public/form');
    js.appendChild(el);
}

setTimeout(render, 0);
