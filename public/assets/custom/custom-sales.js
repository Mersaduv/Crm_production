jQuery(document).ready(function(){
  const ROOT_DIR = '/CRM';

    // Publish notification when terminate requests sent   
    Echo.channel('request')
       .listen('requestEvent',function(){
            
        // Publish Notifications        
        if (! ('Notification' in window)) {
          alert('Web Notification is not supported');
          return;
        }

        Notification.requestPermission( permission => {
          let notification = new Notification('Customer Terminate Request', {
            body: "Please Check Your list, New Customer Terminate Request",
          });
          
        });

        // update the list
        $.ajax({
           url: "/CRM/request/terminate/customer",
           method:'get',
           success:function(response)
           {
            $('#sales_table_requests').empty().html(response);
           }
        });    

    });

    // Publish Notification when installation cancelled or rollbacked
    Echo.channel('CancelEvent')
        .listen('CancelEvent',function(){

        // Publish Notifications        
        if (! ('Notification' in window)) {
          alert('Web Notification is not supported');
          return;
        }

        Notification.requestPermission( permission => {
          let notification = new Notification('Installation cancelled!', {
            body: "Please Check Your list, Installation process cancelled.",
          });
          
        });

        // update the list
        $.ajax({
           url: "/CRM/sales/cancels/customers",
           method:'get',
           success:function(response)
           {
            $('#sales_cancels_table').empty().html(response);
           }
        });    
    });   

    // Publish notification by suspending the customers   
    Echo.channel('fiancneSuspend')
       .listen('financeSuspendEvent',function(){
            
        // Publish Notifications        
        if (! ('Notification' in window)) {
          alert('Web Notification is not supported');
          return;
        }

        Notification.requestPermission( permission => {
          let notification = new Notification('Customer Suspend!', {
            body: "Please Check Your list, New Customer Suspend.",
          });
          
        });

        // update the list
        $.ajax({
           url: "/CRM/sales/suspend/event",
           method:'get',
           success:function(response)
           {
            $('#sales_suspend_table').empty().html(response);
           }
        });    

    });

    // Publish notification by suspending the customers   
    Echo.channel('nocSuspend')
        .listen('nocSuspendEvent',function(){
            
        // Publish Notifications        
        if (! ('Notification' in window)) {
          alert('Web Notification is not supported');
          return;
        }

        Notification.requestPermission( permission => {
          let notification = new Notification('Customer Suspend!', {
            body: "Please Check Your list, New Customer Suspend.",
          });
          
        });

        // update the list
        $.ajax({
           url: "/CRM/sales/suspend/event",
           method:'get',
           success:function(response)
           {
            $('#sales_suspend_table').empty().html(response);
           }
        });    

    });

    // Publish notification by processing customer 
    Echo.channel('nocProcess')
        .listen('nocProcessEvent',function(){
            
        // Publish Notifications        
        if (! ('Notification' in window)) {
          alert('Web Notification is not supported');
          return;
        }

        Notification.requestPermission( permission => {
          let notification = new Notification('Customer Proceed By NOC!', {
            body: "Please Check Your list, New Customer has been Proceed.",
          });
          
        });   

    });

    /***********************************************************/ 
    /*****************Provincial Customers**********************/ 
    /***********************************************************/ 

    // Publish notification for new suspend
    Echo.channel('prFinanceSuspend')
        .listen('prFinanceSuspend',function(){
        
          // Publish Notifications        
        if (! ('Notification' in window)) {
          alert('Web Notification is not supported');
          return;
        }

        Notification.requestPermission( permission => {
          let notification = new Notification('New Suspend!', {
            body: "Please Check Your list, New Customer Suspend.",
          });
          
        });

        // update the list
        $.ajax({
           url: "/CRM/pr/sales/suspendEvent",
           method:'get',
           success:function(response)
           {
            $('#pr_sales_suspend').empty().html(response);
           }
        });

    }); 

    // Publish notification for new suspend
    Echo.channel('prNocSuspend')
        .listen('prNocSuspend',function(){
        
          // Publish Notifications        
        if (! ('Notification' in window)) {
          alert('Web Notification is not supported');
          return;
        }

        Notification.requestPermission( permission => {
          let notification = new Notification('New Suspend!', {
            body: "Please Check Your list, New Customer Suspend.",
          });
          
        });

        // update the list
        $.ajax({
           url: "/CRM/pr/sales/suspendEvent",
           method:'get',
           success:function(response)
           {
            $('#pr_sales_suspend').empty().html(response);
           }
        });

    });

    // Publish notification for new suspend
    Echo.channel('prNocCancel')
        .listen('prNocCancel',function(){
        
          // Publish Notifications        
        if (! ('Notification' in window)) {
          alert('Web Notification is not supported');
          return;
        }

        Notification.requestPermission( permission => {
          let notification = new Notification('New Cancels!', {
            body: "Please Check Your list, New Customer Canceled.",
          });
          
        });

        // update the list
        $.ajax({
           url: "/CRM/pr/sales/cancelEvent",
           method:'get',
           success:function(response)
           {
            $('#pr_sales_cancels').empty().html(response);
           }
        });

    }); 

    // Publish notification for terminate request
    Echo.channel('prTrRequestEvent')
        .listen('prTrRequestEvent',function(){
        
          // Publish Notifications        
        if (! ('Notification' in window)) {
          alert('Web Notification is not supported');
          return;
        }

        Notification.requestPermission( permission => {
          let notification = new Notification('New Terminate Request!', {
            body: "Please Check Your list, New Terminate Request.",
          });
          
        });

        // update the list
        $.ajax({
           url: "/CRM/pr/tr/requests",
           method:'get',
           success:function(response)
           {
            $('#pr_table_requests').empty().html(response);
           }
        });

    });  

});