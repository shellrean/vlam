<template>
	<div>
		<notifications group="foo" />
		<div class="c-wrapper">
			<transition name="slide-fade">
			<router-view />
			</transition>
		</div >
	</div>
</template>