<?php
/**
 * The Docmed demo: everything colorlibhub.com/docmed-blocks/ shows that
 * the theme itself does not build.
 *
 * The theme's own activation builds the seven starter pages and the menu
 * (inc/front-page-setup.php). This adds what a real clinic's site would have
 * on top: the site title and tagline, an author ("Docmed Clinic", Author role,
 * this site only — user 1 is never touched), six blog posts with categories,
 * tags, featured photographs and comments, and it removes WordPress's
 * "Hello world!" and "Sample Page".
 *
 * Run it with the theme active, from WP-CLI, as the user PHP runs as:
 *
 *     sudo -u www-data wp --path=/var/www/colorlibhub.com/public \
 *       --url=https://colorlibhub.com/docmed-blocks/ \
 *       eval "require '/path/to/demo/import.php';"
 *
 * `wp eval` + `require`, not `wp eval-file`: eval-file runs the file inside a
 * function, where a top-level variable is not a global. Everything below lives
 * in functions anyway, so either works, but require is the tested path.
 *
 * Safe to run twice. Posts are found by slug with get_posts() — never
 * get_page_by_path(), which also matches attachments — and a photograph is
 * uploaded only once, found again by the `_docmed_demo_file` meta it is
 * given. The photographs sit in media/ next to this file and are sideloaded from there;
 * none of them ships in the theme zip.
 *
 * The Playground blueprint (.dev/blueprint.json) runs this same file.
 *
 * @package Docmed
 */

defined( 'ABSPATH' ) || exit;

require_once ABSPATH . 'wp-admin/includes/image.php';
require_once ABSPATH . 'wp-admin/includes/file.php';
require_once ABSPATH . 'wp-admin/includes/media.php';

if ( ! function_exists( 'docmed_demo_log' ) ) {

	/**
	 * Print a line, through WP-CLI when there is one.
	 *
	 * @param string $line Message.
	 */
	function docmed_demo_log( $line ) {
		if ( defined( 'WP_CLI' ) && WP_CLI ) {
			WP_CLI::log( $line );
		} else {
			echo esc_html( $line ) . "\n";
		}
	}

	/**
	 * The posts. Plain lines: `## ` is a heading, `> words — who` a quote.
	 *
	 * @return array[]
	 */
	function docmed_demo_posts() {
		return array(
			array(
				'slug'     => 'your-first-visit',
				'title'    => 'Your first visit: what to bring and what to expect',
				'category' => 'Clinic news',
				'tags'     => array( 'new patients', 'appointments' ),
				'image'    => 'first-visit-consultation.jpg',
				'alt'      => 'A doctor in glasses and a white coat taking notes as a bearded patient talks to her across the desk',
				'days'     => 3,
				'excerpt'  => 'A first appointment takes about twenty minutes longer than the ones after it. Here is how to make those minutes count.',
				'body'     => array(
					'A first appointment at Docmed takes about twenty minutes longer than the ones after it. Most of that time is spent listening: to what brought you in, and to the history a new doctor has no other way of knowing.',
					'## What to bring',
					'Bring a photo ID, your insurance card if you have one, and a list of every medicine you take, including vitamins and anything bought over the counter. If you have letters or results from another clinic, bring those too, or ask them to send a copy to us before the day.',
					'## What happens on the day',
					'Arrive ten minutes early so reception can set up your record. A nurse will take your height, weight and blood pressure, and then you will see the doctor you booked. There is always time at the end to ask questions, and nothing is decided about your care without you.',
					'> I write down three questions before every appointment. Nobody has ever made me feel silly for reading them out. — A patient since 2015',
					'If you need an interpreter, or would like a family member with you, tell us when you book and we will plan the appointment around it.',
				),
				'comment'  => array( 'Helen Park', 'Thank you for this. I brought my list of medicines and it saved so much time.' ),
			),
			array(
				'slug'     => 'childrens-check-ups-a-guide-for-parents',
				'title'    => "Children's check-ups: a guide for parents",
				'category' => "Children's health",
				'tags'     => array( 'children', 'check-ups' ),
				'image'    => 'family-paediatric-consult.jpg',
				'alt'      => 'A grandfather and his grandson in a consultation with a doctor, who is pointing at her notes',
				'days'     => 8,
				'excerpt'  => 'When the routine check-ups happen, what Dr. Saleh looks at, and why nobody minds a nervous child.',
				'body'     => array(
					'Routine check-ups are how we notice small things early and, just as often, how we reassure a worried parent that everything is on track. Dr. Amira Saleh runs the children\'s clinic every weekday afternoon.',
					'## What a check-up covers',
					'We measure height and weight and plot them on your child\'s growth chart, check hearing and eyesight at the right ages, and talk through sleep, eating and development. Vaccinations are offered at the same visit when they are due, so there is one appointment rather than two.',
					'## Nervous children are welcome',
					'Many children are anxious about doctors, and that is fine. Bring a favourite toy, tell us beforehand if something in particular worries them, and we will take it slowly. A child who leaves with a sticker and a good memory is more important to us than a check-up finished in record time.',
				),
				'comment'  => array( 'Tom Brennan', 'Dr. Saleh let my son listen to his own heartbeat. He has talked about it all week.' ),
			),
			array(
				'slug'     => 'getting-ready-for-flu-season',
				'title'    => 'Getting ready for flu season',
				'category' => 'Family medicine',
				'tags'     => array( 'vaccinations', 'seasonal' ),
				'image'    => 'doctor-in-mask.jpg',
				'alt'      => 'A close-up of a doctor in black-rimmed glasses and a blue surgical mask, looking into the camera',
				'days'     => 14,
				'excerpt'  => 'Flu vaccine clinics start in October. Who they are for, how to book, and what to do if you are already unwell.',
				'body'     => array(
					'Our flu vaccine clinics start in the first week of October and run on weekday mornings and Saturdays until the end of November.',
					'## Who should book',
					'Your doctor or pharmacist can tell you whether the vaccine is recommended for you. It is usually offered to older adults, people with long-term conditions, pregnant patients and some children, but the advice changes from year to year, so ask us if you are not sure.',
					'## If you are already unwell',
					'Please do not come to a vaccine clinic with a fever. Call the same-day line instead and we will advise you, and rebook your vaccine for when you are better. If you are having trouble breathing, call your local emergency number.',
				),
			),
			array(
				'slug'     => 'back-pain-at-a-desk',
				'title'    => 'Back pain at a desk: small changes that help',
				'category' => 'Physiotherapy',
				'tags'     => array( 'back pain', 'exercise' ),
				'image'    => 'physio-hip-assessment.jpg',
				'alt'      => 'A physiotherapist in blue scrubs moving a patient\'s leg as he lies on his side on a blue treatment table',
				'days'     => 21,
				'excerpt'  => 'Karim Haddad on the desk habits he suggests most often, and when back pain is worth an appointment.',
				'body'     => array(
					'Most of the back pain Karim Haddad sees in the physiotherapy room is not caused by one bad movement but by the same position held for hours. The good news is that small, regular changes often make a noticeable difference.',
					'## Move more often, not harder',
					'Stand up every half hour, even for a minute. Take phone calls on your feet. Set the top of your screen at eye level so your head is not leaning forward all day. None of this needs special equipment.',
					'## When to book an appointment',
					'Book a physiotherapy assessment if pain lasts more than a couple of weeks, keeps coming back, or stops you sleeping. See a doctor the same day if back pain comes with numbness, weakness in the legs, or problems with your bladder or bowels.',
				),
				'comment'  => array( 'Sam Okoro', 'The screen height tip alone has helped. Booked an assessment for the rest.' ),
			),
			array(
				'slug'     => 'how-often-should-you-have-your-eyes-tested',
				'title'    => 'How often should you have your eyes tested?',
				'category' => 'Eye care',
				'tags'     => array( 'eye tests', 'children' ),
				'image'    => 'child-eye-test.jpg',
				'alt'      => 'A young girl sitting in an optometrist\'s chair while the optometrist looks over his shoulder at her from the desk',
				'days'     => 29,
				'excerpt'  => 'Every two years is the usual answer, but not for everyone. Dr. Paredes explains who should come more often.',
				'body'     => array(
					'For most adults with healthy eyes, a sight test every two years is enough. Dr. Lucia Paredes, who runs our eye care clinic, explains who should come more often.',
					'## More often for some',
					'Children, people with diabetes, anyone with a family history of glaucoma, and adults over sixty are usually advised to come every year. Your optometrist will tell you the right interval for you after your first test.',
					'## Do not wait for the next test',
					'Book sooner if your vision changes, if you see new floaters or flashes of light, or if an eye is red and painful. Sudden loss of vision in one eye needs urgent care the same day.',
				),
			),
			array(
				'slug'     => 'understanding-your-blood-test-results',
				'title'    => 'Understanding your blood test results',
				'category' => 'Diagnostics',
				'tags'     => array( 'lab', 'results' ),
				'image'    => 'blood-sample-tube.jpg',
				'alt'      => 'Gloved hands holding up a blood sample tube with a purple cap above a rack of coloured tubes',
				'days'     => 36,
				'excerpt'  => 'Why a result slightly outside the range is not always a worry, and how your doctor will be in touch.',
				'body'     => array(
					'Blood samples taken at Docmed are processed by our partner laboratory, and results come back to your doctor, usually within two to three working days.',
					'## Reading the ranges',
					'Each result is printed beside a reference range. A value slightly outside it is common and does not always mean something is wrong: ranges are set so that a small share of healthy people fall outside them. Your doctor reads the whole picture, not a single number.',
					'## How we contact you',
					'If a result needs action, your doctor will call you. Normal results are sent by secure message or letter. If you have not heard from us within a week, call reception and we will check.',
				),
			),
		);
	}

	/**
	 * Turn the plain lines into block markup.
	 *
	 * @param string[] $lines Paragraphs, `## ` headings and `> ` quotes.
	 * @return string
	 */
	function docmed_demo_blocks( $lines ) {
		$out = array();
		foreach ( $lines as $line ) {
			if ( 0 === strpos( $line, '## ' ) ) {
				$out[] = "<!-- wp:heading -->\n<h2 class=\"wp-block-heading\">" . esc_html( substr( $line, 3 ) ) . "</h2>\n<!-- /wp:heading -->";
			} elseif ( 0 === strpos( $line, '> ' ) ) {
				list( $words, $who ) = array_map( 'trim', explode( '—', substr( $line, 2 ) ) );
				$out[]               = "<!-- wp:quote -->\n<blockquote class=\"wp-block-quote\"><!-- wp:paragraph -->\n<p>" . esc_html( $words ) . "</p>\n<!-- /wp:paragraph --><cite>" . esc_html( $who ) . "</cite></blockquote>\n<!-- /wp:quote -->";
			} else {
				$out[] = "<!-- wp:paragraph -->\n<p>" . esc_html( $line ) . "</p>\n<!-- /wp:paragraph -->";
			}
		}
		return implode( "\n\n", $out );
	}

	/**
	 * The ID of a post of this type with this slug, in any status, or 0.
	 *
	 * @param string $slug Slug.
	 * @param string $type Post type.
	 * @return int
	 */
	function docmed_demo_find( $slug, $type ) {
		$ids = get_posts(
			array(
				'name'             => $slug,
				'post_type'        => $type,
				'post_status'      => array( 'publish', 'draft', 'pending', 'private', 'future' ),
				'posts_per_page'   => 1,
				'fields'           => 'ids',
				'suppress_filters' => true,
			)
		);
		return $ids ? (int) $ids[0] : 0;
	}

	/**
	 * An attachment for one of the photographs next to this file, uploaded once.
	 *
	 * @param string $file    File name in this directory.
	 * @param int    $post_id Post to attach a new upload to.
	 * @param string $title   Attachment title.
	 * @param string $alt     Alt text.
	 * @return int Attachment ID, or 0.
	 */
	function docmed_demo_media( $file, $post_id, $title, $alt ) {
		$found = get_posts(
			array(
				'post_type'      => 'attachment',
				'post_status'    => 'inherit',
				'meta_key'       => '_docmed_demo_file', // phpcs:ignore WordPress.DB.SlowDBQuery -- a one-off import.
				'meta_value'     => $file, // phpcs:ignore WordPress.DB.SlowDBQuery
				'posts_per_page' => 1,
				'fields'         => 'ids',
			)
		);
		if ( $found ) {
			update_post_meta( $found[0], '_wp_attachment_image_alt', $alt );
			return (int) $found[0];
		}

		$source = __DIR__ . '/media/' . $file;
		if ( ! is_readable( $source ) ) {
			docmed_demo_log( "  missing photograph: $file" );
			return 0;
		}

		// media_handle_sideload() moves the file it is given, so hand it a copy.
		$tmp = wp_tempnam( $file );
		copy( $source, $tmp );
		$id = media_handle_sideload(
			array(
				'name'     => $file,
				'tmp_name' => $tmp,
			),
			$post_id,
			$title
		);
		if ( is_wp_error( $id ) ) {
			docmed_demo_log( '  upload failed: ' . $file . ' — ' . $id->get_error_message() );
			if ( file_exists( $tmp ) ) {
				wp_delete_file( $tmp );
			}
			return 0;
		}

		update_post_meta( $id, '_wp_attachment_image_alt', $alt );
		update_post_meta( $id, '_docmed_demo_file', $file );
		return (int) $id;
	}

	/**
	 * A category by name, created when missing.
	 *
	 * @param string $name Category name.
	 * @return int Term ID, or 0.
	 */
	function docmed_demo_category( $name ) {
		$term = term_exists( $name, 'category' );
		if ( ! $term ) {
			$term = wp_insert_term( $name, 'category' );
		}
		return is_array( $term ) ? (int) $term['term_id'] : 0;
	}

	/**
	 * Run the import.
	 */
	function docmed_demo_import() {
		if ( ! function_exists( 'docmed_create_front_page' ) ) {
			docmed_demo_log( 'Docmed is not the active theme on ' . home_url( '/' ) . ' — activate it first. Nothing imported.' );
			return;
		}

		// Site identity. The header prints the site title beside the mark.
		update_option( 'blogname', 'Docmed' );
		update_option( 'blogdescription', 'Family clinic on Green Lane' );

		// The starter pages and menu are the theme's own job. Its function is
		// one-shot and checks every slug, so calling it again only fills in what
		// activation did not get to (for example when it ran before patterns
		// were registered).
		docmed_create_front_page();
		docmed_demo_log( 'starter pages: ' . get_option( DOCMED_SETUP_FLAG ) );

		// WordPress's own sample content.
		foreach ( array( array( 'hello-world', 'post' ), array( 'sample-page', 'page' ) ) as $sample ) {
			$id = docmed_demo_find( $sample[0], $sample[1] );
			if ( $id ) {
				wp_delete_post( $id, true );
				docmed_demo_log( "removed {$sample[1]} {$sample[0]}" );
			}
		}

		// The posts' byline: an author of their own, created once, with the
		// Author role on this site only. User 1 is never renamed — on the
		// colorlibhub network that is the super admin.
		$user = get_user_by( 'login', 'docmed-clinic' );
		if ( ! $user ) {
			$uid = wp_insert_user(
				wp_slash(
					array(
						'user_login'   => 'docmed-clinic',
						'user_pass'    => wp_generate_password( 32, true, true ),
						'user_email'   => 'docmed-clinic@example.com',
						'display_name' => 'Docmed Clinic',
						'nickname'     => 'Docmed Clinic',
						'first_name'   => 'Docmed',
						'last_name'    => 'Clinic',
						'role'         => 'author',
					)
				)
			);
			$author = is_wp_error( $uid ) ? 0 : (int) $uid;
			docmed_demo_log( $author ? "author created: Docmed Clinic (#$author)" : 'author could not be created: ' . $uid->get_error_message() );
		} else {
			$author = (int) $user->ID;
			if ( is_multisite() && ! is_user_member_of_blog( $author ) ) {
				add_user_to_blog( get_current_blog_id(), $author, 'author' );
			}
		}
		if ( ! $author ) {
			$admins = get_users(
				array(
					'role'   => 'administrator',
					'number' => 1,
					'fields' => 'ID',
				)
			);
			$author = $admins ? (int) $admins[0] : 1;
		}

		// Activation from WP-CLI runs with no user, so the starter pages are
		// saved with author 0. Give them the same author as the posts — in the
		// table, not through wp_update_post(): that re-saves the content through
		// kses, which strips the contact page's map <iframe> when there is no user.
		global $wpdb;
		foreach ( array_keys( docmed_starter_pages() ) as $slug ) {
			$page = docmed_demo_find( $slug, 'page' );
			if ( $page && ! (int) get_post_field( 'post_author', $page ) ) {
				$wpdb->update( $wpdb->posts, array( 'post_author' => $author ), array( 'ID' => $page ) ); // phpcs:ignore WordPress.DB.DirectDatabaseQuery
				clean_post_cache( $page );
			}
		}

		foreach ( docmed_demo_posts() as $post ) {
			$id = docmed_demo_find( $post['slug'], 'post' );

			if ( ! $id ) {
				$id = wp_insert_post(
					wp_slash(
						array(
							'post_title'    => $post['title'],
							'post_name'     => $post['slug'],
							'post_excerpt'  => $post['excerpt'],
							'post_content'  => docmed_demo_blocks( $post['body'] ),
							'post_status'   => 'publish',
							'post_author'   => $author,
							'post_date'     => wp_date( 'Y-m-d H:i:s', time() - $post['days'] * DAY_IN_SECONDS ),
							'post_category' => array( docmed_demo_category( $post['category'] ) ),
							'tags_input'    => $post['tags'],
						)
					),
					true
				);
				if ( is_wp_error( $id ) ) {
					docmed_demo_log( 'post failed: ' . $post['slug'] . ' — ' . $id->get_error_message() );
					continue;
				}
				docmed_demo_log( 'created post ' . $post['slug'] );
			} else {
				docmed_demo_log( 'kept post ' . $post['slug'] );
			}

			if ( ! has_post_thumbnail( $id ) ) {
				$media = docmed_demo_media( $post['image'], $id, $post['title'], $post['alt'] );
				if ( $media ) {
					set_post_thumbnail( $id, $media );
				}
			}

			if ( ! empty( $post['comment'] ) ) {
				list( $who, $words ) = $post['comment'];
				$has                 = get_comments(
					array(
						'post_id'      => $id,
						'search'       => $words,
						'count'        => true,
					)
				);
				if ( ! $has ) {
					wp_insert_comment(
						wp_slash(
							array(
								'comment_post_ID'  => $id,
								'comment_author'   => $who,
								'comment_content'  => $words,
								'comment_approved' => 1,
								'comment_date'     => wp_date( 'Y-m-d H:i:s', time() - ( $post['days'] - 1 ) * DAY_IN_SECONDS ),
							)
						)
					);
				}
			}
		}

		$count = wp_count_posts( 'post' );
		docmed_demo_log( sprintf( 'done: %d published posts, %d pages', $count->publish, wp_count_posts( 'page' )->publish ) );
	}
}

docmed_demo_import();
