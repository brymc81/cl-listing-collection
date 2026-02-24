(() => {
  const handleClick = (event) => {
    if (event.defaultPrevented) {
      return;
    }

    const target = event.target.closest('.cl-card[data-url]');
    if (!target) {
      return;
    }

    if (event.target.closest('a')) {
      return;
    }

    const url = target.getAttribute('data-url');
    if (!url) {
      return;
    }

    const linkTarget = target.getAttribute('data-target') || '_self';
    if (linkTarget === '_blank') {
      window.open(url, '_blank', 'noopener');
      return;
    }

    window.location.assign(url);
  };

  document.addEventListener('click', handleClick);
})();
