<div class="col-lg-3">
	<div class="list-group">
		<a href="#" class="list-group-item disabled">
			后台管理
		</a>
		<a href="<?php echo u('grade/index')?>" class="list-group-item <?php if(CONTROLLER=='grade'): ?>active<?php endif; ?>">班级</a>
		<a href="<?php echo u('student/index')?>" class="list-group-item <?php if(CONTROLLER=='student'): ?>active<?php endif; ?>">学生</a>
		<a href="<?php echo u('user/updatePassword')?>" class="list-group-item <?php if(CONTROLLER=='user'): ?>active<?php endif; ?>">用户</a>
		<a href="<?php echo u('attachment/index')?>" class="list-group-item <?php if(CONTROLLER=='attachment'): ?>active<?php endif; ?>">附件</a>
	</div>
</div>