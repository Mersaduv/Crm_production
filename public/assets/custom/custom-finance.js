jQuery(document).ready(function(){

	/*
  *   Publish Notification when customer sent to payment
  *   Update the list of new customers in finance
  */ 

    Echo.channel('process')
        .listen('processEvent',function(){

        // Publish Notifications        
        if (! ('Notification' in window)) {
          alert('Web Notification is not supported');
          return;
        }

        Notification.requestPermission( permission => {
          let notification = new Notification('New Customer Request!', {
            body: "Please Check Your list, New Request received.",
          });
          
        });

        // update the list
        $.ajax({
           url: "/CRM/update/customers/new",
           method:'get',
           success:function(response)
           {
            $('#finance_table_body').empty().html(response);
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
           url: "/CRM/finance/cancels/customers",
           method:'get',
           success:function(response)
           {
            $('#finance_cancels_table').empty().html(response);
           }
        });    
    });  

    // Publish notification when customer has been suspended    
    Echo.channel('suspend')
        .listen('suspendEvent',function(){
           
         // Publish Notifications        
        if (! ('Notification' in window)) {
          alert('Web Notification is not supported');
          return;
        }

        Notification.requestPermission( permission => {
          let notification = new Notification('Customer Suspended!', {
            body: "Please Check Your list, New Customer Suspended.",
          });
          
        });

        // update the list
        $.ajax({
           url: "/CRM/suspend/finance/customer",
           method:'get',
           success:function(response)
           {
            $('#finance_table_suspend').empty().html(response);
           }
        });   

    });

    // Publish notification when customer has been suspended    
    Echo.channel('nocSuspend')
        .listen('nocSuspendEvent',function(){
           
         // Publish Notifications        
        if (! ('Notification' in window)) {
          alert('Web Notification is not supported');
          return;
        }

        Notification.requestPermission( permission => {
          let notification = new Notification('Customer Suspended!', {
            body: "Please Check Your list, New Customer Suspended.",
          });
          
        });

        // update the list
        $.ajax({
           url: "/CRM/suspend/finance/customer",
           method:'get',
           success:function(response)
           {
            $('#finance_table_suspend').empty().html(response);
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

    // Publish notification when customer has been terminated
    Echo.channel('terminate')
        .listen('terminateEvent',function(){

         // Publish Notifications        
        if (! ('Notification' in window)) {
          alert('Web Notification is not supported');
          return;
        }

        Notification.requestPermission( permission => {
          let notification = new Notification('Customer Terminated!', {
            body: "Please Check Your list, New Customer Terminated.",
          });
          
        });

        // update the list
        $.ajax({
           url: "/CRM/terminate/finance/customer",
           method:'get',
           success:function(response)
           {
            $('#finance_table_terminate').empty().html(response);
           }
        }); 

    });

    // Publish notification for new amedments
    Echo.channel('amendment')
        .listen('amendmentEvent',function(){
        
          // Publish Notifications        
        if (! ('Notification' in window)) {
          alert('Web Notification is not supported');
          return;
        }

        Notification.requestPermission( permission => {
          let notification = new Notification('Customer Amedment!', {
            body: "Please Check Your list, New Customer Amedment.",
          });
          
        });

        // update the list
        $.ajax({
           url: "/CRM/amed/finance/customer",
           method:'get',
           success:function(response)
           {
            $('#finance_table_amed').empty().html(response);
           }
        });

    }); 

    /***********************************************************/ 
    /*****************Provincial Customers**********************/ 
    /***********************************************************/ 

    //Publish notification for new cashier
    Echo.channel('prProcess')
        .listen('prProcessEvent',function(){
        
          // Publish Notifications        
        if (! ('Notification' in window)) {
          alert('Web Notification is not supported');
          return;
        }

        Notification.requestPermission( permission => {
          let notification = new Notification('New Customer!', {
            body: "Please Check Your list, New Customer for process.",
          });
          
        });

        // update the list
        $.ajax({
           url: "/CRM/pr/fin/payment",
           method:'get',
           success:function(response)
           {
            $('#pr_finance_requests').empty().html(response);
           }
        });

    });

    // Publish notification for new terminates
    Echo.channel('prTerminate')
        .listen('prTerminateEvent',function(){
        
          // Publish Notifications        
        if (! ('Notification' in window)) {
          alert('Web Notification is not supported');
          return;
        }

        Notification.requestPermission( permission => {
          let notification = new Notification('New Termination!', {
            body: "Please Check Your list, New Customer Termination.",
          });
          
        });

        // update the list
        $.ajax({
           url: "/CRM/pr/fin/terminate",
           method:'get',
           success:function(response)
           {
            $('#pr_terminate_finance').empty().html(response);
           }
        });

    });

    // Publish notification for new suspend
    Echo.channel('prSalesSuspend')
        .listen('prSalesSuspend',function(){
        
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
           url: "/CRM/pr/finance/suspendEvent",
           method:'get',
           success:function(response)
           {
            $('#pr_finance_suspend').empty().html(response);
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
           url: "/CRM/pr/finance/suspendEvent",
           method:'get',
           success:function(response)
           {
            $('#pr_finance_suspend').empty().html(response);
           }
        });

    }); 

    // Publish notification for new amendment
    Echo.channel('prAmendmentEvent')
        .listen('prAmendmentEvent',function(){
        
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
           url: "/CRM/pr/finance/amendEvent",
           method:'get',
           success:function(response)
           {
            $('#pr_finance_amends').empty().html(response);
           }
        });

    });

    // Publish notification for Cancels
    Echo.channel('prSalesCancel')
        .listen('prSalesCancel',function(){
        
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
           url: "/CRM/pr/finance/cancelEvent",
           method:'get',
           success:function(response)
           {
            $('#pr_finance_cancels').empty().html(response);
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
           url: "/CRM/pr/finance/cancelEvent",
           method:'get',
           success:function(response)
           {
            $('#pr_finance_cancels').empty().html(response);
           }
        });

    });    

});