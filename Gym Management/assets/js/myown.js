


function Member_Add()
{

	md.showNotification('bottom','right','Member Added Successfully',3);

}



function changeTherapy()
{
	 var x = parseInt(document.getElementById("vis_therapy_pkgs").value);

	 document.getElementById('vis_therapy_price').value=x;
	 var x=parseInt(document.getElementById('temp_pkg').value);
	var th=parseInt(document.getElementById('vis_therapy_price').value);
	document.getElementById('vis_subtotal').value=x+th;
	calculateGrandTotal();

}
function calculateGrandTotal()
{
	var cost=parseInt(document.getElementById('vis_subtotal').value);
	var tax=parseInt(document.getElementById('vis_tax').value);
	var tx=parseFloat(tax/100);
	var tst=cost*tx;
  document.getElementById('tax_price').value=tst;
	document.getElementById('vis_grandtotal').value=tst+cost;

}
function calcRem()
{
	
	var costt=parseInt(document.getElementById('vis_grandtotal').value);
	document.getElementById('vis_rem_balance').value=costt-parseInt(document.getElementById('vis_payment').value);
}
   function attachCheckboxHandlers() {
   
                 var el = document.getElementById('daily_pkgs');
                var pkgs = el.getElementsByTagName('input');
              
    
            for (var i=0, len=pkgs.length; i<len; i++) {
                  if ( pkgs[i].type === 'checkbox' ) {
            pkgs[i].onclick = updateTotal;
              }
          }
        }
    attachCheckboxHandlers();
// called onclick of toppings checkboxes
function updateTotal(e) {
    // 'this' is reference to checkbox clicked on
    var form = this.form;

    // get current value in total text box, using parseFloat since it is a string
    var val =  parseInt(form.elements['temp_pkg'].value) ;
    
    // if check box is checked, add its value to val, otherwise subtract it
    if ( this.checked ) {
        val += parseInt(this.value);
        calculateGrandTotal();

    } else {
        val -= parseInt(this.value);
    }
    
    // format val with correct number of decimal places
    // and use it to update value of total text box
    //form.elements['mem_monthly_price'].value = val;
    document.getElementById('temp_pkg').value=val;
  	document.getElementById('vis_subtotal').value=val+parseInt(document.getElementById('vis_therapy_price').value);
  	
    //document.getElementById('mem_grand_total').value=val;
}



