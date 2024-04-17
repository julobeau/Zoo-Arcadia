function addReview(){
    const formulaireHtml = document.getElementById('reviewForm')
    const formData = new FormData(formulaireHtml)
    const answers = {}
    formData.forEach(
        (value, key) => {
            if(value != ""){
                answers[key] = value
            }
        }
    )
    postData(JSON.stringify(answers), resultMessage)
}

function resultMessage(result){
    const resultObj = JSON.parse(result)
    const parentDiv = document.getElementById('modal-body')
    const monElement = document.createElement("div")
    monElement.classList.add("alert", "alert-success")
    monElement.innerHTML = `<p>Message envoyé. Merci ${resultObj.pseudo}</p><p>Votre note: ${resultObj.note}</p><p>Votre commentaire: ${resultObj.comment}</p><p>sera affiché dès qu'il sera validé par nos équipes.</p>`
    parentDiv.prepend(monElement)
    document.getElementById('inputPseudo').value=""
    document.getElementById('inputComment').value=""
    document.getElementById('inputNote').selectedIndex=0;
}

function postData(data, callback) {
    const requestOptions = {
        method: "POST",
        body: data,
        redirect: "follow"
    };

    fetch(`http://www.zoo-arcadia.dvlp/api/review`, requestOptions)
        .then((response) => response.json())
        .then((result) => {
            callback(result)
        })
        .catch((error) => console.error(error))
}

if(!!document.getElementById('submitReview')){
    const btnSubmit = document.getElementById('submitReview')
    btnSubmit.addEventListener("click", addReview)
}
