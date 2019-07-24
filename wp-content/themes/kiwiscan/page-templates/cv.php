<?php
/**
 * Template name: CV
 * 
 * This template displays a CV. It uses different CPT :
 * - Expériences Professionnelles
*/

get_header();
?>

	<div id="primary" class="content-area">
		<main id="main" class="site-main cv-main">

		<?php
		//1. Get sticky CV post
		$args_cv = [
		  'post_type'         => 'kscv_cv',
		  'meta_key'          => '_sticky_ks_cv',
		  'meta_value_num'    => 1,
		  'post_per_page'     => 1
		
		];
		$cv = new WP_Query($args_cv);
		if ( $cv->have_posts() ) :
            while ( $cv->have_posts() ) :
                $cv->the_post();
		
                $cv_id = get_the_ID();
    		    
                ?>
                <section>
                    <?php 
                    // contact part
                    get_template_part( 'template-parts/cv/contact');
                    ?>
                </section>
				
				<section> 
    				<?php
    				//links part
    			    get_template_part( 'template-parts/cv/links');
    			    ?>
    			</section>
    			
    			<section>
    			    <?php
    			    //presentation part
    			    get_template_part( 'template-parts/cv/profile');
    			    ?>
                </section>
			    
			    <div class="divided-section">
    			    <?php 
    			    //skills part
    			    get_template_part( 'template-parts/cv/skills');
    			    ?>
			    </div>
			    
			    <?php
    		    //Get jobs of the CV
    		    $cv_job_ids = get_post_meta($cv_id, '_kscv_cv_job');
    		    if( ! empty($cv_job_ids) ) :
        		    $args_jobs = [
        		        'post_type'       => 'kscv_job',
        		        'post__in'        => $cv_job_ids,
        		        'meta_key'        => '_kscv_job_startdate',
        		        'meta_type'       => 'DATETIME',
        		        'orderby'         => 'meta_value_datetime',
        		        'order'           => 'DESC',
        		        'post_per_page'   => -1
        		    ];
        		    
        		    $job_loop = new WP_Query($args_jobs);
        		    if ( $job_loop->have_posts() ) :
        		        ?>
        		        <section class="job-list">
        		        	<h1><span>Expériences professionnelles</span></h1>
            		        <?php 
            		        while ( $job_loop->have_posts() ) :
            		            $job_loop->the_post();
            		            get_template_part( 'template-parts/cv/job' );
            		        endwhile;
            		        ?>
        		        </section>
        		        <?php
        		        //back to the parent Loop context
        		        $cv->reset_postdata();
        		    endif;
        		endif;
    		    
    		    //Get education of the CV
        		$cv_edu_ids = get_post_meta($cv_id, '_kscv_cv_education');
        		if( ! empty($cv_edu_ids) ) :
            		$args_edus = [
            		    'post_type'       => 'kscv_education',
            		    'post__in'        => $cv_edu_ids,
            		    'meta_key'        => '_kscv_edu_startdate',
            		    'meta_type'       => 'DATETIME',
            		    'orderby'         => 'meta_value_datetime',
            		    'order'           => 'ASC',
            		    'post_per_page'   => -1
            		];
        		
            		$edu_loop = new WP_Query($args_edus);
            		if ( $edu_loop->have_posts() ) :
            		  ?>
        		        <section class="edu-list">
        		        	<h1><span>Formations</span></h1>
            		        <?php 
            		        while ( $edu_loop->have_posts() ) :
            		            $edu_loop->the_post();
            		            get_template_part( 'template-parts/cv/education' );
            		        endwhile;
            		        ?>
        		        </section>
        		        <?php
        		        //back to the parent Loop context
        		        $cv->reset_postdata();
        		    endif;
        		endif;
    		    ?>
    		    
        		<div class="divided-section">
            		<?php 
        		    //get taxo language
            		get_template_part( 'template-parts/cv/languages');
            		
            		//get taxo formation
            		get_template_part( 'template-parts/cv/formations');
        		    
        		    // get taxo hobbies
            		get_template_part( 'template-parts/cv/hobbies');
        		    
        		    
            		?>
            	</div>
    		    <?php 
    		    
		    endwhile; 
		endif;
		
		// back to the template main Loop context
		wp_reset_postdata();
		
		
		
		?>

		</main><!-- #main -->
	</div><!-- #primary -->

<?php
get_footer();