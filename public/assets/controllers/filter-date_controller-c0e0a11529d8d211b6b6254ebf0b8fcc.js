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
        const selectDate = Array.from(document.querySelectorAll("[data-date]"))

        for(let date of selectDate){
            date.addEventListener('click', this.filterReports)
        }
    }

    filterReports = (e) =>
    {
        e.preventDefault();
        const reportsList = Array.from(document.querySelectorAll("[data-reportdate]"))
        let date = e.target.dataset.date

        if(date === 'all'){
                for(let report of reportsList){
                    report.parentNode.style.display=""
                }
        }
        else{
            for(let report of reportsList)
            {
                if(report.dataset.reportdate === date){
                    report.parentNode.style.display=""
                }
                else{
                    report.parentNode.style.display="none"
                }
            }
        }
    }
}
