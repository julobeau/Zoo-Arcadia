let selectAnimals = Array.from(document.querySelectorAll("[data-animal]"))
let reportsList = Array.from(document.querySelectorAll("[data-reportanimal]"))

function filterReports(animalName)
{
    if(animalName === 'tous'){
            for(let report of reportsList){
                report.parentNode.style.display=""
            }
    }
    else{
        for(let report of reportsList)
        {
            console.log('rapport ' + report.dataset.reportanimal)
            if(report.dataset.reportanimal === animalName){
                report.parentNode.style.display=""
            }
            else{
                report.parentNode.style.display="none"
            }
        }
    }
}

function addClick(element) {
    element.addEventListener("click", (e) => {
        e.preventDefault()
        filterReports(element.dataset.animal)
    })
}

for(let animal of selectAnimals){
    addClick(animal)
}
