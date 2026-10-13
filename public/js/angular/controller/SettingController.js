app.controller('SettingController', function($scope, $http, API){
	$http({
      method: 'GET',
      url: API + 'setting/hotline/list'
	   }).then(function (response){
	   		$scope.dsphone = response.data;
	   },function (error){

	});

	$scope.modal = function (state,id) {
		$scope.state = state
		switch (state) {
			case "add" :
				$scope.frmTitle = "Thêm số hotline";
				break;
			case "edit" :
				$scope.frmTitle = "Sửa số hotline";
				$scope.id = id;
				$http({
			      method: 'GET',
			      url: API + 'setting/hotline/edit/' + id
				   }).then(function (response){
				   		$scope.hotline = response.data;
				   },function (error){

				});
				break;
			default :
				console.log('exit');
				location.reload(API+'setting/hotline');
				break;
		}
		$("#myModal").modal('show');
	}

	$scope.addHotline = function (state,id){
		if (state == "add") {
			var url = API + "setting/hotline/add";
			var data = $.param($scope.hotline);
			$http({
				method : 'POST',
				url : url,
				data : data,
				headers : {'Content-Type':'application/x-www-form-urlencoded'}
			})
			.then(function (response){
				console.log(response);
				location.reload(API+'setting/hotline');
			},function(error){
				console.log(response);
				alert('Có lỗi xảy ra');
			});
		}

		if (state == "edit") {
			var url = API + "setting/hotline/edit/" + id;
			var data = $.param($scope.hotline);
			$http({
				method : 'POST',
				url : url,
				data : data,
				headers : {'Content-Type':'application/x-www-form-urlencoded'}
			})
			.then(function (response){
				console.log(response);
				location.reload(API+'setting/hotline');
			},function(error){
				console.log(response);
				alert('Có lỗi xảy ra');
			});
		}

		if (state == 'exit'){
			console.log('exit');
			location.reload(API+'setting/hotline');
		}
	}

	$scope.confirmDelete = function (id) {
		var isConfirmDelete = confirm('Bạn có chắc muốn xóa dòng dữ liệu này hay không');
		if (isConfirmDelete) {
			$http.get(API + 'setting/hotline/del/' + id)
				.then(function (response){
					console.log(response);
					location.reload(API+'setting/hotline');
				},function(error){
					console.log(response);
					alert('Có lỗi xảy ra');
				});
		} else {
			return false;
		}
	}

});


app.controller('CompanyController', function($scope, $http, API){
	$http({
      method: 'GET',
      url: API + 'setting/company/list'
	   }).then(function (response){
	   		$scope.dscom = response.data;
	   },function (error){

	});

	$scope.modal = function (state,id) {
		$scope.state = state
		switch (state) {
			case "edit" :
				$scope.frmTitle = "Chỉnh sửa thông tin";
				$scope.id = id;
				$http({
			      method: 'GET',
			      url: API + 'setting/company/edit/' + id
				   }).then(function (response){
				   		$scope.hotline = response.data;
				   },function (error){

				});
				break;
			default :
				console.log('exit');
				location.reload(API+'setting/hotline');
				break;
		}
		$("#myModal").modal('show');
	}

	$scope.addHotline = function (state,id){
		if (state == "edit") {
			var url = API + "setting/company/edit/" + id;
			var data = $.param($scope.hotline);
			$http({
				method : 'POST',
				url : url,
				data : data,
				headers : {'Content-Type':'application/x-www-form-urlencoded'}
			})
			.then(function (response){
				console.log(response);
				location.reload(API+'setting/company');
			},function(error){
				console.log(response);
				alert('Có lỗi xảy ra');
			});
		}

		if (state == 'exit'){
			console.log('exit');
			location.reload(API+'setting/company');
		}
	}

});