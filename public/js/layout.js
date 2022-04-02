
        

        $(function(){
            // $('.menu-trigger').on('click',function(){
            //     if($(this).hasClass('active')){
            //         $(this).removeClass('active');
            //         $('nav').removeClass('open');
            //         $('.overlay').removeClass('open');
            //     } else {
            //         $(this).addClass('active');
            //         $('nav').addClass('open');
            //         $('.overlay').addClass('open');
            //     }
            // });
            $('.menu-trigger').on('click',function(){
                $(".reser").toggle();
                
            });
            // $('.overlay').on('click',function(){
            //     if($(this).hasClass('open')){
            //         $(this).removeClass('open');
            //         $('.menu-trigger').removeClass('active');
            //         $('nav').removeClass('open');      
            //     }
            // });

            $('.sub-menu').click(function(){
                $("*").removeClass("selected");

                $(this).addClass("selected");               
                // $("*").removeClass('sub-menu-nav-ac');
                // $(this).siblings().removeClass('not-active');
                // if($(".sub-menu-nav").is(':visible')){
                //     $(".sub-menu-nav").is(':visible').toggle();
                // }
                
               
                $(this).siblings().addClass("open");
                $(this).siblings().toggle();
                
            });


            $('.res').click(function () {
                if(this.id !== "✕"){    
                    $("*").removeClass("selectedd");            
                    $(this).addClass("selectedd");
                }
            });
        // });
        });
