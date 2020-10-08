$(function () {
	
	const table = $('table').DataTable({
		serverSide: true,
		ajax: {
			url: ajaxUrl,
			dataType: 'json'
		},
		columns: [
			{ data: 'DT_RowIndex' },
			{ data: 'name' },
			{
				data: 'action',
				orderable: false,
				searchable: false
			}
		]
	})

	const reload = () => table.ajax.reload()

	$('tbody').on('click', '.edit', function () {
		let data = table.row($(this).parents('tr')).data() 
		let modal = $('#edit')

		let action = updateUrl.replace(':id', data.id)

		modal.find('form').attr('action', action)
		modal.find('[name=name]').val(data.name)
		modal.find('input').removeClass('is-invalid')

		modal.modal('show')
	})

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
				this.reset()
				$(this).find('input').removeClass('is-invalid')
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

	$('#edit form').submit(function (e) {
		e.preventDefault()

		$.ajax({
			url: this.action,
			type: 'post',
			data: $(this).serialize(),
			dataType: 'json',
			success: res => {
				let msg = `<div class="alert alert-success alert-dismissible">${res.msg}<button class="close" data-dismiss="alert">&times;</button></div>`
				
				$('#alert').html(msg)
				$('#edit').modal('hide')
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

})