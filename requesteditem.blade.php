@extends('layouts.layout')
@section('content')
<div class="right_col" role="main">
<div class="">
        <div class="page-title">
          <div class="title_left">
            <h3>Request Item</h3>
          </div>

          <div class="title_right">
            <div class="col-md-5 col-sm-5 col-xs-12 form-group pull-right top_search">
              <div class="input-group">
                <input type="text" class="form-control" placeholder="Search for...">
                <span class="input-group-btn">
                  <button class="btn btn-default" type="button">Go!</button>
                </span>
              </div>
            </div>
          </div>
        </div>
        <div class="clearfix"></div>
        <div class="row">
                <div id="user" class="col-md-12" >
                  <div class="panel panel-default panel-table animated slideInDown">
                   <div class="panel-body">
                     <div class="tab-content">
                      <div role="tabpanel" class="tab-pane active" id="list">
                       <table class="table table-striped table-bordered table-list">
                        <thead>
                         <tr>
                            <th class="avatar">Item Image</th>
                            <th>Item Name</th>
                            <th>Item Category</th>
                            <th>Item Quantity</th>
                            <th>Cost</th>
                          </tr> 
                         </thead>
                         <tbody>
                          <tr class="ok">
                             <td class="avatar"><img src="https://pbs.twimg.com/profile_images/746779035720683521/AyHWtpGY_400x400.jpg"></td>
                             <td>Djelal Eddine </td>
                             <td>Algeria </td>
                             <td>djelaleddine@gmail.com </td>
                             <td align="center">
                             </td>
                          </tr>
                          <tr class="ban">
                             <td class="avatar"><img src="https://pbs.twimg.com/profile_images/3511252200/f97a40336742d17609e0b0ca17e301b8_400x400.jpeg"></td>
                             <td>Moh Aymen </td>
                             <td>Algeria </td>
                             <td>email@gmail.com </td>
                             <td align="center">
                               
                             </td>
                          </tr>
                          <tr class="new">
                             <td class="avatar"><img src="https://pbs.twimg.com/profile_images/3023221270/fcb34337f850c1037af9840ebe510d36_400x400.jpeg"></td>
                             <td>Dia ElHak  </td>
                             <td>Tunisia </td>
                             <td>email@gmail.com </td>
                             <td align="center">
                               
                              </td>
                            </tr>
                          </tbody>
                        </table>
                      </div><!-- END id="list" -->
                        
                      <div role="tabpanel" class="tab-pane " id="thumb">
                        <div class="row">
                        <div class="col-md-12">
                        
                        <div class="ok">
                         <div class="col-md-3">
                         <div class="panel panel-default panel-thumb">
                              <div class="panel-heading">
                                <h3 class="panel-title">Djelal Eddine</h3>
                              </div>
                              <div class="panel-body avatar-card">
                                <img src="https://pbs.twimg.com/profile_images/746779035720683521/AyHWtpGY_400x400.jpg">
                             </div>
                            <div class="panel-footer">
                               <a href="#" class="btn btn-primary" title="Edit"    ><i class="fa fa-pencil"></i></a>
                               <a href="#" class="btn btn-warning" title="ban"	 ><i class="fa fa-ban"   ></i></a>
                               <a href="#" class="btn btn-danger"  title="delete"  ><i class="fa fa-trash" ></i></a>
                            </div>
                         </div>
                         </div>
                       </div>
                          
                        <div class="ban">
                         <div class="col-md-3">
                         <div class="panel panel-default panel-thumb">
                              <div class="panel-heading">
                                <h3 class="panel-title">Moh Aymen</h3>
                              </div>
                              <div class="panel-body avatar-card">
                                <img src="https://pbs.twimg.com/profile_images/3511252200/f97a40336742d17609e0b0ca17e301b8_400x400.jpeg">
                             </div>
                            <div class="panel-footer">
                               <a href="#" class="btn btn-primary" title="Edit"    ><i class="fa fa-pencil">		</i></a>
                               <a href="#" class="btn btn-warning" title="ban"	 ><i class="fa fa-ban"   >admitted</i></a>
                               <a href="#" class="btn btn-danger"  title="delete"  ><i class="fa fa-trash" >		</i></a>
                            </div>
                         </div>
                         </div>
                       </div>
                        
                        <div class="new">
                         <div class="col-md-3">
                         <div class="panel panel-default panel-thumb">
                              <div class="panel-heading">
                                <h3 class="panel-title">Dia ElHak</h3>
                              </div>
                              <div class="panel-body avatar-card">
                                <img src="https://pbs.twimg.com/profile_images/3023221270/fcb34337f850c1037af9840ebe510d36_400x400.jpeg">
                             </div>
                            <div class="panel-footer">
                               <a href="#" class="btn btn-primary" title="Edit"    ><i class="fa fa-pencil"	  >		</i></a>
                               <a href="#" class="btn btn-success" title="validate"><i class="fa fa-check-square">validate</i></a>
                               <a href="#" class="btn btn-warning" title="ban"	 ><i class="fa fa-ban"		 >		</i></a>
                               <a href="#" class="btn btn-danger"  title="delete"  ><i class="fa fa-trash"	   >		</i></a>
                            </div>
                         </div>
                         </div>
                       </div>
                       
                       </div>
                      </div>
                      </div><!-- END id="thumb" -->
                       
                     </div><!-- END tab-content --> 
                    </div>
                   
                   <div class="panel-footer text-center">
                           <ul class="pagination">
                           <li ><a>«</a></li>
                           <li class="active"><a href="#">1</a></li>
                           <li ><a href="#">2</a></li>
                           <li ><a href="#">3</a></li>
                           <li ><a>»</a></li>
                         </ul>
                   </div>
                  </div><!--END panel-table-->
                </div>
                </div>
</div>
</div>
@endsection
        
