var adminurl = 'http://www.lylaloves.co.uk/admin/index.php/json/';
var service = angular.module('Service', []);
service.factory('MainJson', function ($http, TemplateService) {

    var cart = [];
    var returntwo = [];
    var subtotal = 0;
    var totalproducts = 0;
    var filters = {
        color: "",
        pricemin: 0,
        pricemax: 30
    };
    var coupondetails=$.jStorage.get("coupon");
    var discount=$.jStorage.get("coupon");

    /*{
		placeorder: function(firstname,lastname,email,company,billingaddress,billingcity,billingstate,billingpincode,billingcountry,phone,fax,shippingaddress,shippingcity,shippingstate,shippingpincode,shippingcountry,id,status) {
		 	return $http.post(adminurl+'placeorder?user='+id+'&firstname='+firstname+'&lastname='+lastname+'&email='+email+'&phone='+phone+'&status='+status+'&fax='+fax+'&company='+company+'&billingaddress='+billingaddress+'&billingcity='+billingcity+'&billingstate='+billingstate+'&billingpincode='+billingpincode+'&billingcountry='+billingcountry+'&shippingaddress='+shippingaddress+'&shippingstate='+shippingstate+'&shippingpincode='+shippingpincode+'&shippingcountry='+shippingcountry,{});
		},*/
    return {
        checkdiscount: function (discountcoupon) {
            return $http.post(adminurl + 'checkdiscount?coupon=' + discountcoupon, {}, {
                withCredentials: true
            });
        },
        getcoupondetails: function () {
            return coupondetails;
        },
        setcoupondetails: function (coupon) {
            $.jStorage.set("coupon",coupon);
            coupondetails=coupon;
        },
        
        getfilters: function () {
            return filters;
        },
        setfilter: function (filter) {
            filters = filter;
        },
        placelimitedemail: function (limited) {
            return $http({
                url: adminurl + 'placelimitedemail',
                method: "POST",
                withCredentials: true,
                data: {
                    'limited': limited
                }
            });
        },
        placelimited: function (limited) {
            return $http({
                url: adminurl + 'placelimited',
                method: "POST",
                withCredentials: true,
                data: {
                    'limited': limited
                }
            });
        },
        placeorder: function (form) {
            return $http({
                url: adminurl + 'placeorder',
                method: "POST",
                withCredentials: true,
                data: {
                    'form': form
                }
            });
        },
        seach: function (search) {
            return $http.post(adminurl + 'searchbyname?search=' + search, {}, {
                withCredentials: true
            });
        },
        showwishlist: function (user) {
            return $http.post(adminurl + 'showwishlist?user=' + user, {}, {
                withCredentials: true
            });
        },
        signupemail: function (email) {
            return $http.post(adminurl + 'signupemail?email=' + email, {}, {
                withCredentials: true
            });
        },
        orderemail: function (email, orderid) {
            return $http.post(adminurl + 'orderemail?email=' + email + '&orderid=' + orderid, {}, {
                withCredentials: true
            });
        },
        logout: function () {
            return $http.post(adminurl + 'logout', {}, {
                withCredentials: true
            });
        },
        usercontact: function (id, name, email, phone, comment) {
            return $http.post(adminurl + 'usercontact?id=' + id + '&name=' + name + '&email=' + email + '&phone=' + phone + '&comment=' + comment, {}, {
                withCredentials: true
            });
        },
        newsletter: function (id, email, status) {
            return $http.post(adminurl + 'newsletter?id=' + id + '&email=' + email + "&status=" + status, {}, {
                withCredentials: true
            });
        },
        addtowishlist: function (user, product) {
            return $http.post(adminurl + 'addtowishlist?user=' + user + '&product=' + product, {}, {
                withCredentials: true
            });
        },
        authenticate: function () {
            return $http.post(adminurl + 'authenticate', {}, {
                withCredentials: true
            });
        },
        registeruser: function (firstname, lastname, email, password) {
            return $http.post(adminurl + 'registeruser?firstname=' + firstname + '&lastname=' + lastname + '&email=' + email + '&password=' + password, {}, {
                withCredentials: true
            });
        },
        registerwholesaler: function (firstname, lastname, phone, email, password) {
            return $http.post(adminurl + 'registewholesaler?firstname=' + firstname + '&lastname=' + lastname + '&phone=' + phone + '&email=' + email + '&password=' + password, {}, {
                withCredentials: true
            });
        },
        loginuser: function (email, password) {
            return $http.post(adminurl + 'loginuser?email=' + email + '&password=' + password, {}, {
                withCredentials: true
            });
        },
        getnavigation: function () {
            return $http.post(adminurl + 'getnavigation', {}, {
                withCredentials: true
            });
        },
        getproductdetails: function (product, category) {
            return $http.get(adminurl + 'getproductdetails', {
                params: {
                    product: product
                }
            }, {
                withCredentials: true
            });
        },
        getproductbycategory: function (category) {
            return $http.get(adminurl + 'getproductbycategory', {
                params: {
                    category: category,
                    color: filters.color,
                    price1: filters.pricemin,
                    price2: filters.pricemax,
                }
            }, {
                withCredentials: true
            });
        },
        getusercart: function (user) {
            return $http.get(adminurl + 'getusercart?user=' + user, {}, {
                withCredentials: true
            });
        },
        getallslider: function (user) {
            return $http.get(adminurl + 'getallslider');
        },
        addtocart: function (id, name, price, quantity) {
            return $http.post(adminurl + 'addtocart?product=' + id + '&productname=' + name + "&quantity=" + quantity + "&price=" + price, {}, {
                withCredentials: true
            });
            /*
            price=parseFloat(price);
            quantity=parseInt(quantity);
            if(isNaN(quantity))
            {
                return;
            }
            var isedit=-1;
            for(var i=0;i<cart.length;i++){
                if(cart[i].id==id)
                {
                    isedit=i;
                }
                
            }
            if(isedit==-1)
            {
		 	    cart.push({id:id,name:name,price:price,quantity:quantity});
                
            }
            else 
            {
                cart[isedit].quantity+=quantity;
            }
            console.log(cart);
            subtotal=this.calcsubtotal();
            return subtotal;
           */
        },
        getcart: function () {
            return $http.post(adminurl + 'showcart', {}, {
                withCredentials: true
            });
            //return cart;
        },
        getdiscountcoupon: function (couponcode) {
            return $http.post(adminurl + 'getdiscountcoupon?couponcode=' + couponcode, {}, {
                withCredentials: true
            });
        },
        gettotalcart: function () {
            return $http.post(adminurl + 'totalitemcart', {}, {
                withCredentials: true
            });
            //return cart;
        },
        totalcart: function () {
            return $http.post(adminurl + 'totalcart', {}, {
                withCredentials: true
            });
            //return cart;
        },
        deletecart: function (id) {

            subtotal = this.calcsubtotal();
            return subtotal;
        },
        deletecartfromsession: function (id) {
            return $http.post(adminurl + 'deletecart?id=' + id, {}, {
                withCredentials: true
            });
        },
        savecart: function (uid, id, quantity) {
            console.log(cart);
            for (var i = 0; i < cart.length; i++) {
                if (cart[i].id == id) {
                    cart[i].quantity = quantity;
                    console.log(cart[i].name);
                    returntwo.state = $http.post(adminurl + 'addtocart?user=' + uid + '&product=' + id + "&quantity=" + cart[i].quantity, {}, {
                        withCredentials: true
                    });
                }

            }
            console.log(cart);
            returntwo.subtotal = this.calcsubtotal();
            return returntwo;
        },
        calcsubtotal: function () {
            subtotal = 0;
            for (var i = 0; i < cart.length; i++) {
                subtotal += cart[i].price * cart[i].quantity;
            }
            console.log(subtotal);
            return subtotal;

        },
        gettotalproductsincart: function (data, status) {
            console.log(data);
            TemplateService.totalproducts = data;
            return 0;
        },


    }
});