function setEventListenerForClasses(func, classname) {
    for (var i = 0; i < classname.length; i++) {
        classname[i].addEventListener('click', func, false);
    }
}
