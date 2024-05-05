import { Controller } from '@hotwired/stimulus';

/*
 * This is an example Stimulus controller!
 *
 * Any element with a data-controller="hello" attribute will cause
 * this controller to be executed. The name "hello" comes from the filename:
 * hello_controller.js -> "hello"
 *
 * Delete this file or adapt it for your use!
 */
export default class extends Controller {

    connect(){
        const selectAnimals = Array.from(document.querySelectorAll("[data-animal]"))

        for(let animal of selectAnimals){
            animal.addEventListener('click', this.filterReports)
        }
    }

    filterReports = (e) =>
    {
        e.preventDefault();
        const reportsList = Array.from(document.querySelectorAll("[data-reportanimal]"))
        let animalName = e.target.dataset.animal

        if(animalName === 'tous'){
                for(let report of reportsList){
                    report.parentNode.style.display=""
                }
        }
        else{
            for(let report of reportsList)
            {
                if(report.dataset.reportanimal === animalName){
                    report.parentNode.style.display=""
                }
                else{
                    report.parentNode.style.display="none"
                }
            }
        }
    }
}
