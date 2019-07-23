@extends('layouts.layout')
@section('content')
<div class="right_col" role="main">
<div class="">
        <div class="page-title">
          <div class="title_left">
            <h3>Work Experience</h3>
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
        <ul class="nav nav-tabs">
            <li class="active"><a data-toggle="tab" href="#home">ADD WORK EXPERIENCE</a></li>
            <li><a data-toggle="tab" href="#menu2">VIEW</a></li>
          </ul>
        
          <div class="tab-content">
            <div id="home" class="tab-pane fade in active">
                <div class="row">
                    <div class="col-md-12 col-sm-12 col-xs-12">
                          <div class="x_panel">
                            <div class="x_title">
                              <h2><small>WORK EXPERIENCE</small></h2>
                              <ul class="nav navbar-right panel_toolbox">
                                <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                                </li>
                                <li class="dropdown">
                                  <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><i class="fa fa-wrench"></i></a>
                                  <ul class="dropdown-menu" role="menu">
                                    <li><a href="#">Settings 1</a>
                                    </li>
                                    <li><a href="#">Settings 2</a>
                                    </li>
                                  </ul>
                                </li>
                                <li><a class="close-link"><i class="fa fa-close"></i></a>
                                </li>
                              </ul>
                              <div class="clearfix"></div>
                            </div>
                            <div class="x_content">
                              <br />
                              <form id="demo-form2" data-parsley-validate class="form-horizontal form-label-left">
          
                                <div class="form-group">
                                  <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Place of Work <span class="required">*</span>
                                  </label>
                                  <div class="col-md-6 col-sm-6 col-xs-12">
                                    <input id="text" class="form-control col-md-7 col-xs-12" required="required" type="text">
                                  </div>
                                </div>
                                <div class="form-group">
                                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">From (Date) <span class="required">*</span>
                                        </label>
                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                          <input id="text" class="form-control col-md-7 col-xs-12" required="required" type="date">
                                        </div>
                                </div>
                                <div class="form-group">
                                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">To (Date) <span class="required">*</span>
                                        </label>
                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                          <input id="text" class="form-control col-md-7 col-xs-12" required="required" type="date">
                                        </div>
                                </div>
                                <div class="form-group">
                                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Address<span class="required">*</span>
                                        </label>
                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                          <input id="text" class="form-control col-md-7 col-xs-12" required="required" type="text">
                                        </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Town <span class="required">*</span>
                                    </label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                      <input id="text" class="date-picker form-control col-md-7 col-xs-12" required="required" type="text">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Position <span class="required">*</span>
                                    </label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                      <input id="text" class="form-control col-md-7 col-xs-12" required="required" type="text">
                                    </div>
                                </div>
                                <div class="ln_solid"></div>
                                <div class="form-group">
                                  <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                                    <button class="btn btn-primary" type="button">Cancel</button>
                                    <button class="btn btn-primary" type="reset">Reset</button>
                                    <button type="submit" class="btn btn-success">Submit</button>
                                  </div>
                                </div>
          
                              </form>
                            </div>
                          </div>
                        </div>
                </div>
            </div>
            <div id="menu2" class="tab-pane fade">
                    <div class="row">
                            <div class="col-md-12 col-sm-12 col-xs-12">
                                  <div class="x_panel">
                                    <div class="x_title">
                                      <h2>View Work Experience<small></small></h2>
                                      <ul class="nav navbar-right panel_toolbox">
                                        <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                                        </li>
                                        <li class="dropdown">
                                          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><i class="fa fa-wrench"></i></a>
                                          <ul class="dropdown-menu" role="menu">
                                            <li><a href="#">Settings 1</a>
                                            </li>
                                            <li><a href="#">Settings 2</a>
                                            </li>
                                          </ul>
                                        </li>
                                        <li><a class="close-link"><i class="fa fa-close"></i></a>
                                        </li>
                                      </ul>
                                      <div class="clearfix"></div>
                                    </div>
                                    <div class="x_content">
                                      <br />
                                      <div class="row">
                                            <!--h2 class="text-danger">Approve User</h2-->
                                            
                                            
                                            <table class="table table-bordered success">
                                                    <thead>
                                                        <tr >
                                                            <th>Place of Work</th>
                                                            <td>Ogunrinde</td>
                                                        </tr>
                                                        <tr>
                                                            <th class="">From (Date)</th>
                                                            <td>First Class</td>
                                                        </tr>
                                                        <tr>
                                                            <th class="">To (Date)</th>
                                                            <td>OAU</td>
                                                        </tr>
                                                        <tr>
                                                            <th class="">Position</th>
                                                            <td>Elect and Elect Engr</td>
                                                        </tr>
                                                        
                                                        <tr>
                                                            <th class="">Address</th>
                                                            <td>1-12-2019</td>
                                                        </tr>
                                                        <tr>
                                                            <th class="">Town</th>
                                                            <td>1-12-2019</td>
                                                        </tr>
                                                    </thead>
                                    
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
@endsection
        
