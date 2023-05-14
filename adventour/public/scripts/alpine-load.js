document.addEventListener("alpine:init", () => {
  function remove(el) {
    if (el.tagName !== "TEMPLATE") {
      return (el.innerHTML = "");
    }
    if (!el._x_loaded_end) return;

    const marker = el._x_loaded_end;
    let node = el.nextSibling;

    while (node !== marker) {
      const temp = node.nextSibling;
      node.remove();
      node = temp;
    }

    marker.remove();
    delete el._x_loaded_end;
  }

  function insertResponse(el, resp) {
    remove(el);

    if (el.tagName !== "TEMPLATE") {
      return (el.innerHTML = resp);
    }

    const marker = document.createTextNode("");
    el.after(marker);
    el._x_loaded_end = marker;

    const temp = document.createElement("template");
    temp.innerHTML = resp;
    el.after(temp.content);
  }

  function showLoader(el) {
    if (el.tagName !== "TEMPLATE") return;
    remove(el);

    const marker = document.createTextNode("");
    el.after(marker);
    el._x_loaded_end = marker;

    const node = el.content.cloneNode(true);
    if (node.childNodes.length === 0) return;

    el.after(node);
  }

  function load(
    el,
    { value, expression, modifiers },
    { effect, cleanup, evaluateLater }
  ) {
    const evaluate = evaluateLater(expression);
    const xhr = new XMLHttpRequest();
    const method = value?.toUpperCase() ?? "GET";

    const listener = xhr.addEventListener("load", () => {
      insertResponse(el, xhr.response);
    });

    effect(() => {
      evaluate((options) => {
        const url = typeof options === "string" ? options : options.url;
        xhr.open(method, url);
        xhr.send(options.body ?? null);

        if (modifiers.indexOf("hidden") !== -1) {
          remove(el);
        }

        if (el.tagName === "TEMPLATE") {
          showLoader(el);
        }
      });
    });

    cleanup(() => {
      xhr.removeEventListener("load", listener);
      xhr.abort();
    });
  }

  Alpine.directive("load", load);
});
