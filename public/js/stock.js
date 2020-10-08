$(function () {
	
	const table = $('table').DataTable({
		serverSide: true,
		ajax: {
			url: ajaxUrl,
			dataType: 'json'
		},
		columns: [
			{ data: 'DT_RowIndex' },
			{ data: 'code' },
			{ data: 'total' },
			{ data: 'date' },
			{
				data: 'action',
				orderable: false,
				searchable: false
			}
		]
	})

	const reload = () => table.ajax.reload()

	const reset = table => {
		table.reset()
		$('[name=total]').removeAttr('max')
		$('[name=total]').next('small').empty()
		$('select').empty()
	}

	$('tbody').on('click', '.delete', function () {
		if (confirm('Delete?')) {
			let data = table.row($(this).parents('tr')).data() 

			let url = deleteUrl.replace(':id', data.id)

			$.ajax({
				url: url,
				method: 'post',
				data: {
					'_method': 'delete',
					'_token': csrf
				},
				dataType: 'json',
				success: res => {
					let msg = `<div class="alert alert-success alert-dismissible">${res.msg}<button class="close" data-dismiss="alert">&times;</button></div>`
					
					$('#alert').html(msg)
					reload()
				}
			})
		}
	})

	$('#create').submit(function (e) {
		e.preventDefault()

		$.ajax({
			url: createUrl,
			type: 'post',
			data: $(this).serialize(),
			dataType: 'json',
			success: res => {
				let msg = `<div class="alert alert-success alert-dismissible">${res.msg}<button class="close" data-dismiss="alert">&times;</button></div>`
				
				$('#alert').html(msg)
				$(this).find('input').removeClass('is-invalid')
				
				reset(this)
				reload()
			},
			error: err => {
				if (err.status === 422) {
					let errors = err.responseJSON.errors
					$.each(errors, function (name, error) {
						let input = $(`[name=${name}]`)
						let msg = error[0]

						input.addClass('is-invalid')
						input.next('.invalid-feedback').html(msg)
					})
				}
			}
		})
	})

	$('[name=code').select2({
		placeholder: 'Code',
		ajax: {
			url: getBookUrl,
			type: 'post',
			data: params => ({
				_token: csrf,
				name: params.term
			}),
			dataType: 'json',
			processResults: res => ({
				results: res
			}),
			cache: true
		}
	})


})