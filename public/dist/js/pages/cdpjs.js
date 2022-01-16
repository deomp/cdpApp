let amountElt = document.getElementById("amount")
let infoElt = document.getElementById('info')
let periodElt = document.getElementById('period')
let initialText = infoElt.textContent
let initialPeriod = periodElt.value


function getMonths() {
    if (amountElt.value >= "50" && amountElt.value <= "99")
	{
        periodElt.value += ",0"

	}
	if (amountElt.value >= "100" && amountElt.value <= "149")
	{
		infoElt.textContent += '+ 1 mois'
        periodElt.value += ",1"
        //console.log('Tu a entrer 100')
		
	}
	else if (amountElt.value >= "150" && amountElt.value <= "199")
	{
		infoElt.textContent += '+ 2 mois'
        periodElt.value += ",2"
	}
	else if (amountElt.value >= "200" && amountElt.value <= "149")
	{
		infoElt.textContent += '+ 3 mois'
        periodElt.value += ",3"
	}
    else if (amountElt.value >= "250" && amountElt.value <= "299")
	{
		infoElt.textContent += '+ 4 mois'
        periodElt.value += ",4"
	}
    else if (amountElt.value >= "300" && amountElt.value <= "349")
	{
		infoElt.textContent += '+ 5 mois'
        periodElt.value += ",5"
	}
    else if (amountElt.value >= "350" && amountElt.value <= "399")
	{
		infoElt.textContent += '+ 6 mois'
        periodElt.value += ",6"
	}
    else if (amountElt.value >= "400" && amountElt.value <= "449")
	{
		infoElt.textContent += '+ 7 mois'
        periodElt.value += ",7"
	}
    else if (amountElt.value >= "450" && amountElt.value <= "499")
	{
		infoElt.textContent += '+ 8 mois'
        periodElt.value += ",8"
	}
    else if (amountElt.value == "500")
	{
		infoElt.textContent += '+ 9 mois'
        periodElt.value += ",9"
	}
}

function clearInput(){
    if ( amountElt.value=="") 
    {
        infoElt.textContent = initialText
        periodElt.value = initialPeriod 
        //console.log('You cleared')
    }

    amountElt.addEventListener('keydown', function(event) {
        const key = event.key;
        if (key === "Backspace" || key === "Delete") {
            //$('#info').html(key + ' is Pressed!');
            infoElt.textContent = initialText
            periodElt.value = initialPeriod 
            
        }
    });

    cardelt.addEventListener('click', function(event) {
        const key = event.key;
        if (key === "Backspace" || key === "Delete") {
            $('#info').html(key + ' is Pressed!');
            infoElt.textContent = initialText
            periodElt.value = initialPeriod 
            
        }
    });
}

function getMembre() {
    var getMember = document.getElementById("nomMembre").value;
    document.getElementById("membre").innerHTML =  "Ajouter Contribution pour " + getMember;
}
