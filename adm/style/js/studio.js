jQuery(function($) {
	let studio = {
		sizes: ['small', 'medium', 'large'],
		corners: ['full', 'squared', 'rounded'],
		colours: [
			'phpbb', 'blue-light', 'dark-blue', 'purple-indigo', 'purple-dark',
			'purple-orange', 'pink-orange', 'orange-light', 'pink-light', 'green-cyan',
			'red', 'purple', 'violet', 'indigo', 'cyan', 'teal', 'blue', 'orange', 'white', 'black',
		],
		construct: function() {
			this.menu.bind();
			this.dashboard.bind();
			this.dropdown.bind();
			this.settings.bind();
			this.search.highlight();

			$('body').on('click', studio.close);
		},
		close: function() {
			studio.dashboard.close();
			studio.dropdown.close();
			studio.settings.close();
		},
		menu: {
			bind: function() {
				$('.studio-cat > a').on('click', studio.menu.collapse);
			},
			collapse: function(e) {
				$('.studio-cat').not($(this).parent()).removeClass('active');

				$(this).parent().toggleClass('active');

				e.preventDefault();
			}
		},
		dashboard: {
			bind: function() {
				$('.studio-dash, .studio-dash-toggle').on('click', studio.dashboard.open);
				$('input', '.studio-dash').on('change', studio.dashboard.save);
			},
			close: function() {
				$('.studio-dash').removeClass('studio-dash-open');
			},
			open: function(e) {
				studio.close();

				$('.studio-dash').addClass('studio-dash-open');

				e.stopPropagation();
			},
			save: function() {
				let form = $(this).parents('form'),
					name = $(this).attr('name');

				$.ajax({
					method: 'POST',
					url: form.attr('action'),
					data: form.serialize(),
					success: function() {
						if (name) {
							studio.dashboard.toggle(name, false);
						}
					}
				});
			},
			toggle: function(setting, toggleInput) {
				let panel = $(`#${setting}`),
					input = $(`#${setting}_input`);

				if ($.inArray(setting, ['display_logs', 'display_users', 'display_stats', 'remodel_stats']) !== -1) {
					window.location.reload();
				}
				else if (panel.length) {
					panel.toggle();

					if (toggleInput && input.length) {
						input.prop('checked', !input.prop('checked'));
					}
				} else if (setting === 'remodel_stats' || setting === 'display_stats') {
					if (setting === 'remodel_stats') {

					}
				}
			},
		},
		dropdown: {
			bind: function() {
				$('.studio-dropdown').on('click', studio.dropdown.open);
			},
			close: function() {
				$('.studio-dropdown').removeClass('studio-dropdown-open');
			},
			open: function(e) {
				studio.close();

				$(this).addClass('studio-dropdown-open');

				e.stopPropagation();
			},
		},
		settings: {
			bind: function() {
				$('.studio-settings, .studio-settings-toggle').on('click', studio.settings.open);
				$('input', '.studio-settings').on('change', studio.settings.save);
			},
			close: function() {
				$('.studio-settings').removeClass('studio-settings-open');
			},
			open: function(e) {
				studio.close();

				$('.studio-settings').addClass('studio-settings-open');

				e.stopPropagation();
			},
			save: function() {
				let form = $(this).parents('form'),
					func = $(this).data('func'),
					obj = $(this).data('obj'),
					val = $(this).is(':checkbox') ? $(this).is(':checked') : $(this).val().toString();

				$.ajax({
					method: 'POST',
					url: form.attr('action'),
					data: form.serialize(),
					success: function() {
						if (typeof studio[obj][func] === 'function') {
							studio[obj][func](val);
						}
					}
				});
			}
		},
		search: {
			highlight: function() {
				let query = window.location.search.substring(1),
					params = query.replace('&amp;', '&').split('&');

				$.each(params, function(i, param) {
					let p = param.split('=');

					if (p[0] === 'studio_search' && p[1] !== undefined) {
						let id = decodeURIComponent(p[1]),
							dl = $(`#${id}`).parents('dl');

						dl.addClass('studio-search-highlight');

						return true;
					}
				});

				return false;
			}
		},

		removePartialClass(element, classPartial) {
			let regex = new RegExp('(^|\\s)' + classPartial + '\\S+');

			$(element).removeClass(function (index, className) {
				return (className.match(regex) || []).join(' ');
			});

			return $(element);
		},

		header: {
			colour: function(colour) {
				colour = $.inArray(colour, studio.colours) !== -1 ? colour : 'white';

				studio.removePartialClass('.studio-header', 'studio-bg-')
					.addClass('studio-bg-' + colour);
			},
			fixed: function(state) {
				$('.studio-header').toggleClass('studio-header-fixed', state);
			}
		},
		sidebar: {
			colour: function(colour) {
				colour = $.inArray(colour, studio.colours) !== -1 ? colour : 'purple-indigo';

				studio.removePartialClass('.studio-sidebar', 'studio-bg-')
					.addClass('studio-bg-' + colour);
			},
			fixed: function(state) {
				$('.studio-sidebar').toggleClass('studio-sidebar-full', state);
			},
			corner: function(corner) {
				corner = $.inArray(corner, studio.corners) !== -1 ? corner : 'rounded';

				studio.removePartialClass('.studio-menu', 'studio-menu-corner-')
					.addClass('studio-menu-corner-' + corner);
			},
			size: function(size) {
				size = $.inArray(size, studio.sizes) !== -1 ? size : 'large';

				studio.removePartialClass('.studio-menu', 'studio-menu-size-')
					.addClass('studio-menu-size-' + size);
			},
		}
	};

	studio.construct();

	phpbb.addAjaxCallback('studio_dashboard', function(res) {
		studio.dashboard.toggle(res.setting, true);
	});

	// This callback will mark all notifications read
	phpbb.addAjaxCallback('notification.mark_all_read', function(res) {
		if (typeof res.success !== 'undefined') {
			phpbb.markNotifications($('#notification_list li.bg2'), 0);
			phpbb.closeDarkenWrapper(3000);
		}
	});

	// This callback will mark a notification read
	phpbb.addAjaxCallback('notification.mark_read', function(res) {
		if (typeof res.success !== 'undefined') {
			var unreadCount = Number($('#notification_list_button strong').html()) - 1;
			phpbb.markNotifications($(this).parent('li.bg2'), unreadCount);
		}
	});

	/**
	 * Mark notification popup rows as read.
	 *
	 * @param {jQuery} $popup jQuery object(s) to mark read.
	 * @param {int} unreadCount The new unread notifications count.
	 */
	phpbb.markNotifications = function($popup, unreadCount) {
		// Remove the unread status.
		$popup.removeClass('bg2');
		$popup.find('a.mark-read').remove();

		// Update the notification link to the real URL.
		$popup.each(function() {
			var link = $(this).find('a');
			link.attr('href', link.attr('data-real-url'));
		});

		// Update the unread count.
		$('strong', '#notification_list_button').html(unreadCount);

		// Remove the Mark all read link and hide notification count if there are no unread notifications.
		if (!unreadCount) {
			$('#mark_all_notifications').remove();
			$('#notification_list_button > strong').addClass('hidden');
		}
	};
});
