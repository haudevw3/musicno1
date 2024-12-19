const BASE_URL = 'http://music-app.online/';
const defaultOptionsApi = {
	useAlert: false,
	useToast: false,
	useLoading: false,
	useInvalidFeedback: false,
	beforeResolvingCallbacks: null,
	resolvingCallbacks: null,
	afterResolvingCallbacks: null,
};

const toastOptions = {
	success: {
		title: 'Thành công',
		class: 'bg-success',
		icon: 'fa-regular fa-circle-check',
	},

	warning: {
		title: 'Cảnh báo',
		class: 'bg-warning',
		icon: 'fa-regular fa-triangle-exclamation',
	},

	danger: {
		title: 'Cảnh báo lỗi',
		class: 'bg-danger',
		icon: 'fa-regular fa-circle-exclamation',
	}
}

var apiGet = async function (url, data, needOptions = {})
{
    var promise;
	var options = {...defaultOptionsApi, ...needOptions};

    try {
        promise = await $.ajax({
            url: url,
            type: 'GET',
            data: data,
            dataType: options.dataType ? options.dataType : 'json',

            success: function (response) {
            },

            error: function (error) {
            }
        });
    } catch (error) {
        console.log(error);
    }

    return promise;
}

var apiCreate = async function (url, data, needOptions = {})
{
	var promise;
	var options = {...defaultOptionsApi, ...needOptions};

	try {
		promise = await $.ajax({
			url: url,
			headers: {
				'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
			},
			type: 'POST',
			data: data,
			dataType: options.dataType ? options.dataType : 'json',

			beforeSend: function () {
				fireBeforeResolvingCallbacks(options);
			},

			success: function (response) {
			},

			error: function (error) {
				fireResolvingCallbacks(error, options);
			},

			complete: function () {
				fireAfterResolvingCallbacks(options);
			}
		});
	} catch (error) {
		console.log(error);
	}

	return promise;
}

var apiUpdate = async function (url, data, needOptions = {})
{
	var promise;
	var options = {...defaultOptionsApi, ...needOptions};

	try {
		promise = await $.ajax({
			url: url,
			headers: {
				'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			},
			type: 'PUT',
			data: data,
			dataType: options.dataType ? options.dataType : 'json',

			beforeSend: function () {
				fireBeforeResolvingCallbacks(options);
			},

			success: function (response) {
			},

			error: function (error) {
				fireResolvingCallbacks(error, options);
			},

			complete: function () {
				fireAfterResolvingCallbacks(options);
			}
		});
	} catch (error) {
		console.log(error);
	}

	return promise;
}

var apiDelete = async function (url, data = {}, needOptions = {})
{
	var promise;
	var options = {...defaultOptionsApi, ...needOptions};

	try {
		promise = await $.ajax({
			url: url,
			headers: {
				'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			},
			type: 'DELETE',
			data: data,
			dataType: 'json',

			success: function (response) {
			},

			error: function (error) {
			}
		});
	} catch (error) {
		console.log(error);
	}

	return promise;
}

var apiUpload = async function (url, data = {}, needOptions = {})
{
	var promise;
	var options = {...defaultOptionsApi, ...needOptions};

	try {
		promise = await $.ajax({
			url: url,
			headers: {
				'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			},
			type: 'POST',
			data: data,
			cache: false,
			contentType: false,
			processData: false,

			success: function (response) {
			},

			error: function (error) {
			}
		});
	} catch (error) {
		console.log(error);
	}

	return promise;
}

function fireBeforeResolvingCallbacks(options)
{
	if (options.useLoading) {
		showLoading(null, 0);
	}

	if (options.beforeResolvingCallbacks != null) {
		options.beforeResolvingCallbacks.apply(null, arguments);
	}
}

function fireResolvingCallbacks(error, options)
{
	var messages = {};

	if (error.responseJSON && error.responseJSON.hasOwnProperty('errors')) {
		var errors = error.responseJSON.errors;
 
		if ($.type(errors) === 'string') {
			messages = errors;
		}
		
		else if ($.type(errors) === 'object') {
			$.each(errors, function (key, array) {
				messages[key] = array[0];
			});
		}
	}
	
	if (options.useAlert) {
		showAlert('danger', messages);
	}

	if (options.useInvalidFeedback) {
		showInvalidFeedback(messages);

		$('#alert').addClass('d-none');
	}
}

function fireAfterResolvingCallbacks(options)
{	
	if (options.useLoading) {
		showLoading(null, 500);
	}
}

function debounce(fn, timeout, callbackTimeout)
{
	var time = Infinity, timed;

	return function () {
		clearTimeout(timed);
		
		if (Date.now() > time + callbackTimeout) {
			time = Date.now();

			fn.apply(null, arguments);
		} else {
			timed = setTimeout(() => {
				time = Date.now();

				fn.apply(null, arguments);
			}, timeout);
		}
	}
}

function showAlert(type, messages)
{
	var defaultClass = 'd-block fw-semibold alert alert-' + type;

	if ($.type(messages) === 'string') {
		$('#alert').text(messages).attr('class', defaultClass);
	}

	else {
		var html = '';
		
		$.each(messages, function (key, value) {
			if (Object.keys(messages).length > 1) {
				html += `<li>${value}</li>`;
			} else {
				html += value;
			}
		});

		$('#alert').html(html).attr('class', defaultClass);
	}
}

function flashAlert(type, message, timeout = 3000)
{
	var defaultClass = 'd-block col-2 fw-semibold animated-fade-in-up flash-alert alert alert-' + type;
	
	$('#alert').text(message).attr('class', defaultClass);
	
	setTimeout(function () {
		$('#alert').text('').attr('class', '');
	}, timeout);
}

function showToast(message, options = {}, timeout = 3000)
{
	var title = (options.title == null) ? 'Thông báo' : options.title;
	var icon = (options.icon == null) ? 'fa-regular fa-bell' : options.icon;
	var defaultClass = (options.class == null) ? 'bg-primary' : options.class;

	$('#toast').addClass('show').removeClass('hide');
	$('#toast-icon').addClass(icon);
	$('#toast-header').addClass(defaultClass);
	$('#toast-title').text(title);
	$('#toast-body').text(message);
	
	setTimeout(function () {
		$('#toast').addClass('hide').removeClass('show');
		$('#toast-icon').removeClass(icon);
		$('#toast-header').removeClass(defaultClass);
		$('#toast-title').text('');	
		$('#toast-body').text('');
	}, timeout);
}

function showLoading(fn = null, timeout = 3000)
{
	$('#loading').removeClass('d-none');

	if (timeout > 0) {
		setTimeout(function () {
			if (fn != null) {
				fn.apply(null, arguments);
			}

			$('#loading').addClass('d-none');
		}, timeout);
	}
}

function showInvalidFeedback(messages)
{
	$.each(messages, function (key, value) {
		var id = '#' + key;

		isInvalid($(id).find('input'));

		$(id).find('.invalid-feedback').text(value);
	});
}

function showDialog(title, message)
{
	$('#dialog').modal('show');
    $('#dialog-title').text(title);
	$('#dialog-body').text(message);
	
	return new Promise(function (resolve, reject) {
		$('#btn-confirm').off('click').on('click', function () {
			$('#modal-dialog').modal('hide');
			resolve(true);
		});

		$('.btn-cancel').off('click').on('click', function () {
			$('#modal-dialog').modal('hide');
			reject(false);
		});
	});
}

function getInputVal($input, required = true)
{
	var val = $input.val();

	isInvalid($input, required && ! val);

	return val;
}

function isInvalid($element, invalid = true)
{
	if (invalid) {
		addInvalid($element);
	} else {
		removeInvalid($element);
	}
}

function addInvalid($element)
{
	$element.addClass('is-invalid').removeClass('is-valid');
}

function removeInvalid($element)
{
	$element.removeClass('is-invalid').removeClass('is-valid');
}

function renderSlug(val)
{
	val = val.replace(/^\s+|\s+$/g, '');
	val = val.toLowerCase();

	var from = 'áàảạãăắằẳẵặâấầẩẫậéèẻẽẹêếềểễệiíìỉĩịóòỏõọôốồổỗộơớờởỡợúùủũụưứừửữựýỳỷỹỵđ·/_,:;';
	var to = 'aaaaaaaaaaaaaaaaaeeeeeeeeeeeiiiiiiooooooooooooooooouuuuuuuuuuuyyyyyd------';

	for (var i = 0, l = from.length; i < l; i++) {
		val = val.replace(new RegExp(from.charAt(i), 'g'), to.charAt(i));
	}

	val = val
			.replace(/[^a-z0-9 -]/g, '')
			.replace(/\s+/g, '-')
			.replace(/-+/g, '-').replace(/^-+/, '')
			.replace(/-+$/, '');
	
	return val;
}