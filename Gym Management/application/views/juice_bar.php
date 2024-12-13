<body id="mycont">
<div  class="main-panel ps-container ps-theme-default ps-active-y" data-ps-id="ad4dab3a-0431-c2c3-e934-a67efb7d756f">
      <!-- Navbar -->
<div class="content">
<div class="container-fluid">
          <div class="row">
            <div class="col-md-12">
              <div class="card ">
                <div class="card-header card-header-primary card-header-text">
                  <div class="card-text">
                    <h4 class="card-title">Juice/Items Bar</h4>
                  </div>
                </div>
                
                <div class="card-body ">
                  <ul class="nav nav-pills nav-pills-info" role="tablist">
                    <li class="nav-item">
                      <a class="nav-link active show"  data-toggle="tab" href="#link1" role="tablist">
                        Juices
                      </a>
                    </li>
                    <li class="nav-item">
                      <a class="nav-link" onclick="cart()" data-toggle="tab" href="#link2" role="tablist">
                        Checkout
                      </a>
                    </li>
                 
                  </ul>
                  <div class="tab-content tab-space">
                    <div class="tab-pane active show" id="link1">
                  <div class="row">

                    <?php 
                  if($juices->num_rows()>0)
                  {
                    foreach($juices->result() as $juice)
                    {
                      ?>
                  <div class="col-md-3  cards">
                  <div class="card card-pricing card-raised">
                    <div class="card-body">
                      <h5 class="card-category">Name: <?php echo $juice->name ?></h5>
                      <h5 class="card-category">Price: $ <?php echo $juice->price ?></h5>
                      <label class="col-sm-4 col-form-label">Quantity</label>
                        <div class="form-group bmd-form-group">
                          <form>
                            <input id="j_id" name="j_id" value="<?php echo $juice->id ?>" hidden>
                          <input style="text-align: center;" type="text" id="qty" name="qty" class="form-control" value="1" required>
                          <input  type="button" onclick="add_item(this.form,this.form.j_id.value,this.form.qty.value)" value="Add to Cart" readonly id="submit_juice" class="btn btn-fill btn-round btn-warning">
                          </form>

                        </div>
     
                    </div>
                  </div>
                </div>

                      <?php

                    }
                  }

                    ?>

              </div>


                    </div>
                    <!------------------------ END OF JUICES ----------->

                    <!------------ CHECKOUT SECTION ----------------------->

                    <div class="tab-pane" id="link2">
                       <div class="card card-plain">

                
                        <div class="card-body">
                    <div class="table-responsive">
                      <table class="table table-hover">
                        <thead class="thead-dark">
                          <tr>
                            
                          <th>Item</th>
                          <th>Quantity</th>
                          <th>Price</th>
                          <th>Subtotal</th>
                          <th>Actions</th>
                        
                        </tr>
                      </thead>
                        <tbody id="cart_rows">
                          
                        </tbody>
                        <tfoot>
                        <td></td>
                        <td></td>
                     
                          <td style="text-align: right"><h5 id="totalPrice">Total: ?></h5></td>
                          <td align="right"><input type="button" onclick="checkout()" value="Place Order" readonly="" id="submit_pkg" class="btn btn-fill btn-success "></td>
                        </tfoot>
                      </table>
                    </div>
                  </div>



                   
                    
                  
                  
                </div>






                    </div>
                 
                  </div>
                </div>
              </div>
            </div>
            
          </div>
          </div>
        </div>

          
        </div>
<script>
function add_item(e,id,qty)
{

  $(document).ready(function(){

    var idd=id;
    var qtyy=qty;
    if(qty==='')
    {
      md.showNotification('bottom','right','Specify Quantity',2);
    }
    else
    {
         $.ajax({

             method:'POST',
             url:'<?php echo base_url('Cart/add') ?>',
              data:{id:idd,qty:qtyy},
               success:function(result)
              {
                if(result=='true')
                {
                 md.showNotification('bottom','right','Package/Item Added Successfully',3);
                }
                else
                {
                   md.showNotification('bottom','right',result,2);
                 }
              }
            });
    }


});



}

function cart()
{
   $(document).ready(function(){

    
         $.ajax({

             method:'POST',
             url:'<?php echo base_url('Cart/getCart') ?>',
              data:{id:'1'},
               success:function(result)
              {
                $('#cart_rows').html(result);
              }
            });
         $.ajax({

          method:'POST',
          url:'<?php echo base_url('Cart/getTotal') ?>',
          data:{id:'1'},
          success:function(result)
          {
            $('#totalPrice').html(result);
          }

         });


});


  
}

function inc_qty(row,qty)
{

     $(document).ready(function(){

    
         $.ajax({

             method:'POST',
             url:'<?php echo base_url('Cart/updateCartInc') ?>',
              data:{rowid:row,qty:qty},
               success:function(result)
              {
                if(result=='true')
                {
                   
                   cart();

                }
                else
                {
                   md.showNotification('bottom','right','Something went wrong',2);
                }
              }
            });
  


});


}
function dec_qty(row,qty)
{
 
       $(document).ready(function(){

    
         $.ajax({

             method:'POST',
             url:'<?php echo base_url('Cart/updateCartDec') ?>',
              data:{rowid:row,qty:qty},
               success:function(result)
              {
                if(result=='true')
                {
                   
                   cart();
                }
                else
                {
                   md.showNotification('bottom','right','Something went wrong',2);
                }
                
              }
            });
  


});


}
function remove_item(row)
{

         $(document).ready(function(){

    
         $.ajax({

             method:'POST',
             url:'<?php echo base_url('Cart/removeItem') ?>',
              data:{rowid:row},
               success:function(result)
              {
                if(result=='true')
                {
                 
                 cart();
                }
                else
                {
                   md.showNotification('bottom','right','Something went wrong',2);
                }
              }
            });
  


});



}
function checkout()
{

         $(document).ready(function(){

    
         $.ajax({

             method:'POST',
             url:'<?php echo base_url('Cart/checkout') ?>',
              data:{id:'1'},
               success:function(result)
              {
                if(result=='true')
                {
                 md.showNotification('bottom','right','Checkout completed',3);
                 cart();
                }
                else
                {
                   md.showNotification('bottom','right','Something went wrong',2);
                }
              }
            });
  


});


}
          

</script>
