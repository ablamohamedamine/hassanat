(function($) {
    $(document).ready(function() {
        const consentPopup = $('#consent-popup');
        const notificationPopup = $('#notification-popup');
        const consentExpirationDays = 365;
                
        function displayHidePopup(el, bottom) {
            el.css({
                'bottom' : bottom
            });
        }

        function displayNotification() {
            
            const randomDelay = Math.floor(Math.random() * 15000) + 1000;
            
            setTimeout(() => {
                getAdhkarData(function (dhikr) {
                    $.ajax({
                        url: notificationsData.ajax_url,
                        type: 'POST',
                        data: {
                            action: 'hassanat_change_dhikr',
                            dhikr: dhikr,
                            security: notificationsData.nonce
                        },
                        success: function(response) {
                            if (response.success) {
                                let textDhikr = response.data.text.replace('((','').replace('))','')
                                $('#dhikr-text').html(textDhikr);
                            }
                        },
                        error: function() {
                            console.error('AJAX request failed');
                        }
                    });
                })
                displayHidePopup(notificationPopup, '30px') 
            }, randomDelay);
        }

        if (!document.cookie.includes('hassanat')) {
            displayHidePopup(consentPopup, '30px')
            
        } else if(document.cookie.includes('hassanat=yes')) {
            displayNotification()
        }

        function getAdhkarData(callback) {

            $.getJSON(notificationsData.pluginUrl + "data/adhkar.json", function(data) {

                const dataIndex = Math.floor(Math.random() * data.length)
                const arrayIndex = Math.floor(Math.random() * data[dataIndex].array.length)

                callback(data[dataIndex].array[arrayIndex].text)
              });
        }
        
        consentPopup.find('button').on('click', function(e) {
            e.preventDefault();
            
            const consentValue = $(this).data('value');
            
            // Send AJAX request to save consent
            $.ajax({
                url: notificationsData.ajax_url,
                type: 'POST',
                data: {
                    action: 'hassanat_display_notification',
                    consent: consentValue,
                    security: notificationsData.nonce
                },
                success: function(response) {
                    if (response.success) {                      
                        if (response.data.hassanat === "yes") {

                            displayNotification()
                            notificationPopup.html(response.data.html)
                        }
                    } else {
                        console.log(response.data.message); 
                    }
                },
                error: function() {
                    console.error('AJAX request failed');
                }
            });
        });

        function setCookie(name, value, days) {
            let expires = "";
            if (days) {
                const date = new Date();
                date.setTime(date.getTime() + (days * 24 * 60 * 60 * 1000));
                expires = "; expires=" + date.toUTCString();
            }
            document.cookie = name + "=" + (value || "") + expires + "; path=/";
        }
        
        function hideNotificationPopup() {
            $('#notification-popup button').on('click', function(e) {
                e.preventDefault;

                displayHidePopup(notificationPopup, '-100%')
                if ($(this).data("value") === "x") {
                    displayNotification()
                }

                if ($(this).data("value") === "no") {
                    setCookie('hassanat', "no" , consentExpirationDays);
                }
            })
        }

        hideNotificationPopup()
    
        function setCookieBtn(data) {
            $('#consent-' + data).on('click', function() {
                setCookie('hassanat', data , consentExpirationDays);
                displayHidePopup(consentPopup, '-100%')
            });
        }
    
        setCookieBtn('yes')
        setCookieBtn('no')
    });
})(jQuery);
