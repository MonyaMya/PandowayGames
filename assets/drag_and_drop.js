
    const draggables = document.querySelectorAll('.draggable')
    const dragContainers = document.querySelectorAll('.dragContainer')
    var position = 0;

    console.log('HEHE DND')
    draggables.forEach(draggable => {


        draggable.addEventListener('dragstart', () => {
            console.log('drag start HEHE')
            position = draggable.getAttribute("position");
            draggable.classList.add('dragging')
        })


        draggable.addEventListener('dragend', () => {
            console.log("dragend " + draggable.getAttribute("position") + " " + position)
            draggable.classList.remove('dragging')
            fetch("/game/mygames/move/" + draggable.getAttribute("position") + "/" + position)
        })
    })


    dragContainers.forEach(dragContainer => {
        dragContainer.addEventListener('dragover', e => {
            e.preventDefault()
            const afterElement = getDragAfterElement(dragContainer, e.clientY)
            console.log(afterElement)
            const draggable = document.querySelector('.dragging')
            if (afterElement == null) {
                dragContainer.appendChild(draggable)
            } else {
                position = afterElement.getAttribute("position");
                dragContainer.insertBefore(draggable, afterElement)
            }
        })
    })


    function getDragAfterElement(dragContainer, y) {
    const draggableElements = [...dragContainer.querySelectorAll('.draggable:not(.dragging)')]
    return draggableElements.reduce((closest, child) => {
        const box = child.getBoundingClientRect()
        const offset = y - box.top - box.height /2
        console.log(offset)
        if (offset < 0 && offset > closest.offset) {
            return {
                offset: offset, element: child
            }
        } else {
            return closest
        }
    }, { offset: Number.NEGATIVE_INFINITY }).element
}
